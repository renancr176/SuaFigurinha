<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MyAlbumRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\AlbumOrder;
use Exception;
use App\Enums\AlbumOrderFileTypeEnum;
use App\Events\AlbumCreatedByClientEvent;

class MyAlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MyAlbumRequest $request, $id)
    {
        $order = AlbumOrder::where('transaction_id', $id)
        ->where('completed', false)
        ->firstOrFail();

        try
        {
            DB::beginTransaction();

            $files = $this->makeAlbum($request, $order);

            $order->client()->updateOrCreate([
                'client_name' => $request->client_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number
            ]);

            $order->deliveryAddress()->updateOrCreate([
                'zipcode' => $request->zipcode,
                'state' => $request->state,
                'city' => $request->city,
                'district' => $request->district,
                'address' => $request->address,
                'address_number' => $request->address_number,
                'complement' => $request->complement,
                'receiver_name' => $request->receiver_name
            ]);

            $order->files()->delete();
            foreach ($files as $file)
                $order->files()->create($file);

            $order->texts()->delete();
            foreach ($request->texts as $pageId => $texts)
                foreach ($texts as $textId => $text)
                    $order->texts()->create([
                        'text' => $text,
                        'album_page_id' => $pageId,
                        'album_page_text_id' => $textId
                    ]);

            $order->update([
                'completed' => true
            ]);

            DB::commit();
        }
        catch (Exception $e)
        {
            $this->deleteFiles($files);

            DB::rollBack();

            throw $e;
        }

        AlbumCreatedByClientEvent::dispatch($order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function makeAlbum(MyAlbumRequest $request, AlbumOrder $order)
    {
        $album = $order->album()->with([
            'pageType',
            'pages' => function($query){
                $query->orderBy('sequence');
            },
            'pages.photos' => function($query){
                $query->orderBy('sequence');
            },
            'pages.photos.frameType',
            'pages.texts',
            'pages.texts.font',
            'pages.backgrounds'
        ])->firstOrFail();

        #region Validations
        foreach ($album->pages as $page)
        {
            foreach ($page->texts as $text)
            {
                if ($request->texts == null
                || !array_key_exists($page->id, $request->texts)
                || !array_key_exists($text->id, $request->texts[$page->id])
                || strlen(trim($request->texts[$page->id][$text->id])) == 0)
                {
                    return response(null, 400);
                }
            }

            foreach ($page->photos as $photo)
            {
                if ($request->photo == null
                || !array_key_exists($page->id, $request->photo)
                || !array_key_exists($photo->id, $request->photo[$page->id]))
                {
                    return response(null, 400);
                }
            }

            foreach ($page->backgrounds as $background)
            {
                if ($request->background == null
                || !array_key_exists($page->id, $request->background)
                || !array_key_exists($background->id, $request->background[$page->id]))
                {
                    return response(null, 400);
                }
            }
        }
        #endregion

        $baseDir = "album_orders/$order->transaction_id";

        $files = [];

        try
        {
            foreach ($album->pages as $page)
            {
                foreach ($page->photos as $photo)
                {
                    $file = [];
                    $file['album_order_file_type_id'] = AlbumOrderFileTypeEnum::Figure;
                    $file['sequence'] = $photo->sequence;
                    $file['path'] = $this->generateImageFile($request->photo[$page->id][$photo->id], $baseDir, "figurinha-$photo->sequence");
                    array_push($files, $file);
                }

                foreach ($page->backgrounds as $background)
                {
                    $file = [];
                    $file['album_order_file_type_id'] = AlbumOrderFileTypeEnum::Background;
                    $file['sequence'] = $background->sequence;
                    $file['path'] = $this->generateImageFile($request->background[$page->id][$background->id], $baseDir, "fundo-$background->sequence-pagina-$page->sequence");
                    array_push($files, $file);
                }

                // if(count($page->backgrounds) > 0 || count($page->texts) > 0)
                // {
                //     $file = [];
                //     $file['album_order_file_type_id'] = AlbumOrderFileTypeEnum::AlbumPage;
                //     $file['sequence'] = $page->sequence;

                //     $albumBasePage = $this->getImageResource(public_path().$page->image_path);

                //     if($albumBasePage == false)
                //         throw new Exception('Erro ao tentar gerar o album.');

                //     list($albumBasePageWidth, $albumBasePageHeight) = getimagesize(public_path().$page->image_path);
                //     imagealphablending($albumBasePage, true);
                //     imagesavealpha($albumBasePage, true);

                //     $newPage = imagecreatetruecolor($this->mmToPx($album->pageType->width), $this->mmToPx($album->pageType->width));
                //     imagealphablending($newPage, true);
                //     imagesavealpha($newPage, true);

                //     foreach ($page->backgrounds as $background)
                //     {
                //         $guid = Uuid::uuid1()->toString();
                //         $pathToBg = $this->generateImageFile($request->background[$page->id][$background->id], $tempDir, "bg-$guid", false);
                //         $bgResourceImage = $this->getImageResource($pathToBg);
                //         if($bgResourceImage == false)
                //             throw new Exception('Erro ao tentar gerar o album.');
                //         imagecopymerge(
                //             $newPage,
                //             $bgResourceImage,
                //             $this->mmToPx($background->x_position),
                //             $this->mmToPx($background->y_position),
                //             0,
                //             0,
                //             $this->mmToPx($background->width),
                //             $this->mmToPx($background->height),
                //             100
                //         );
                //         imagedestroy($bgResourceImage);
                //     }

                //     imagecopyresized(
                //         $newPage,
                //         $albumBasePage,
                //         0,
                //         0,
                //         0,
                //         0,
                //         $this->mmToPx($album->pageType->width),
                //         $this->mmToPx($album->pageType->width),
                //         $albumBasePageWidth,
                //         $albumBasePageHeight
                //     );

                //     // foreach ($page->texts as $text)
                //     // {
                //     //     $rgb = $this->getRgbFormHex($text->color);
                //     //     $textColor = imagecolorallocate($newPage, $rgb['r'], $rgb['g'], $rgb['b']);
                //     //     imagettftext(
                //     //         $newPage,
                //     //         $text->font_size,
                //     //         $text->rotation,
                //     //         $text->x_position,
                //     //         $text->y_position,
                //     //         $textColor,
                //     //         public_path().$text->font->path,
                //     //         trim($request->texts[$page->id][$text->id]));
                //     // }

                //     $file['path'] = $this->generateImageFile($this->resourceImageToBase64($newPage), $baseDir, "page-$page->sequence");
                //     array_push($files, $file);
                // }
            }
        }
        catch (Exception $e)
        {
            $this->deleteFiles($files);

            $files = [];

            throw $e;
        }

        return $files;
    }

    private function generateImageFile($base64Image, $path, $imageName, $useStorage = true)
    {
        $imageType = $this->getImageType($base64Image);
        $base64Image = explode(',', $base64Image)[1];

        switch($imageType)
        {
            case 'image/png':
                $imageName .= '.png';
                break;
            case 'image/jpeg':
            default:
                $imageName .= '.jpg';
                break;
        }

        $content = base64_decode($base64Image);
        $fileName = "$path/$imageName";
        if($useStorage)
            Storage::disk('local')->put($fileName, $content);
        else
            file_put_contents($fileName, $content);
        return $fileName;
    }

    private function getImageType($base64Image)
    {
        return explode(':', explode(';', explode(',', $base64Image)[0])[0])[1];
    }

    private function deleteFiles(array $files)
    {
        foreach($files as $file)
        {
            Storage::disk('local')->delete($file['path']);
        }
    }

    // /**
    //  * @param string $filename — Path to the PNG image.
    //  * @return resource|false — an image resource identifier on success, false on errors.
    // */
    // private function getImageResource($imagePath)
    // {
    //     switch(strtolower(pathinfo($imagePath)['extension']))
    //     {
    //         case 'png':
    //             return imagecreatefrompng($imagePath);
    //         case 'jpg':
    //         case 'jpeg':
    //             return imagecreatefromjpeg($imagePath);
    //         default:
    //             return false;
    //     }
    // }

    // /**
    //  * @param resource $resourceImage — An image resource identifier.
    //  * @return string — an base64 string.
    // */
    // private function resourceImageToBase64($resourceImage)
    // {
    //     imagefilter($resourceImage, IMG_FILTER_PIXELATE, 1, true);
    //     imagefilter($resourceImage, IMG_FILTER_MEAN_REMOVAL);

    //     ob_start();
    //     imagepng($resourceImage);
    //     $contents = ob_get_contents();
    //     ob_end_clean();

    //     return "data:image/png;base64,".base64_encode($contents);
    // }

    // private function getRgbFormHex($hex)
    // {
    //     $hex = str_replace('#', '', $hex);
    //     $rgb = [];
    //     $rgb['r'] = hexdec(substr($hex, 0, 2));
    //     $rgb['g'] = hexdec(substr($hex, 2, 2));
    //     $rgb['b'] = hexdec(substr($hex, 4, 2));
    //     return $rgb;
    // }

    // private function mmToPx($mm)
    // {
    //     $px = $mm * 3.779528;
    //     return $px;
    // }

    // private function pxToMm($px)
    // {
    //     $mm = $px / 3.779528;
    //     return $mm;
    // }
}