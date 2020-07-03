<?php

use Illuminate\Database\Seeder;

class AlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Album::create([
            'page_type_id' => 5,
            'ref_code' => 'A015',
            'title' => 'AMOR DO OIAPOQUE AO CHUI',
            'price' => 0,
            'description' => '',
            'page_orientation' => 'Portrait',
            'active' => true
        ]);

        #region Page 1

        App\AlbumPage::create([
            'album_id' => 1,
            'sequence' => 1,
            'image_path' => '/files/images/albuns/album_1/img_1.png'
        ]);

        App\AlbumPageBackground::create([
            'album_page_id' => 1,
            'width' => 142,
            'height' => 113,
            'x_position' => 33.5,
            'y_position' => 48.5,
            'rotation' => 0,
            'controls_position' => 'top'
        ]);

        App\AlbumPageText::create([
            'album_page_id' => 1,
            'font_id' => 2,
            'text' => 'Eu e Ele(a)',
            'alignment' => 'center',
            'color' => '#F26955',
            'font_size' => 46,
            'bold' => false,
            'italic' => false,
            'underlined' => false,
            'width' => 210,
            'x_position' => 0,
            'y_position' => 170,
            'rotation' => 0,
            'controls_position' => 'bottom'
        ]);

        #endregion

        #region Page 2

        App\AlbumPage::create([
            'album_id' => 1,
            'sequence' => 2,
            'image_path' => '/files/images/albuns/album_1/img_2.png'
        ]);

        App\AlbumPagePhoto::create([
            'album_page_id' => 2,
            'album_frame_type_id' => 2,
            'sequence' => 1,
            'x_position' => 100,
            'y_position' => 100,
            'rotation' => 0,
            'controls_position' => 'top'
        ]);

        App\AlbumPagePhoto::create([
            'album_page_id' => 2,
            'album_frame_type_id' => 2,
            'sequence' => 2,
            'x_position' => 400,
            'y_position' => 100,
            'rotation' => 0,
            'controls_position' => 'top'
        ]);

        App\AlbumPagePhoto::create([
            'album_page_id' => 2,
            'album_frame_type_id' => 2,
            'sequence' => 3,
            'x_position' => 100,
            'y_position' => 400,
            'rotation' => 0,
            'controls_position' => 'bottom'
        ]);

        App\AlbumPagePhoto::create([
            'album_page_id' => 2,
            'album_frame_type_id' => 2,
            'sequence' => 4,
            'x_position' => 400,
            'y_position' => 400,
            'rotation' => 0,
            'controls_position' => 'bottom'
        ]);

        #endregion

        #region Page 3

        App\AlbumPage::create([
            'album_id' => 1,
            'sequence' => 3,
            'image_path' => '/files/images/albuns/album_1/img_3.png'
        ]);

        App\AlbumPagePhoto::create([
            'album_page_id' => 3,
            'album_frame_type_id' => 2,
            'sequence' => 5,
            'x_position' => 50,
            'y_position' => 100,
            'rotation' => 0,
            'controls_position' => 'top'
        ]);

        App\AlbumPagePhoto::create([
            'album_page_id' => 3,
            'album_frame_type_id' => 2,
            'sequence' => 6,
            'x_position' => 50,
            'y_position' => 400,
            'rotation' => 0,
            'controls_position' => 'bottom'
        ]);

        App\AlbumPageBackground::create([
            'album_page_id' => 3,
            'width' => 120,
            'height' => 210,
            'x_position' => 90,
            'y_position' => 0,
            'rotation' => 0,
            'controls_position' => 'right'
        ]);

        #endregion

        #region Page 4

        App\AlbumPage::create([
            'album_id' => 1,
            'sequence' => 4,
            'image_path' => '/files/images/albuns/album_1/img_4.png'
        ]);

        App\AlbumPagePhoto::create([
            'album_page_id' => 4,
            'album_frame_type_id' => 2,
            'sequence' => 7,
            'x_position' => 100,
            'y_position' => 50,
            'rotation' => 0,
            'controls_position' => 'top'
        ]);

        App\AlbumPagePhoto::create([
            'album_page_id' => 4,
            'album_frame_type_id' => 2,
            'sequence' => 8,
            'x_position' => 400,
            'y_position' => 50,
            'rotation' => 0,
            'controls_position' => 'top'
        ]);

        App\AlbumPageBackground::create([
            'album_page_id' => 4,
            'width' => 150,
            'height' => 110,
            'x_position' => 100,
            'y_position' => 380,
            'rotation' => 0,
            'controls_position' => 'left'
        ]);

        #endregion

        #region Page 5

        App\AlbumPage::create([
            'album_id' => 1,
            'sequence' => 5,
            'image_path' => '/files/images/albuns/album_1/img_5.png'
        ]);

        App\AlbumPagePhoto::create([
            'album_page_id' => 5,
            'album_frame_type_id' => 2,
            'sequence' => 9,
            'x_position' => 100,
            'y_position' => 100,
            'rotation' => 0,
            'controls_position' => 'top'
        ]);

        App\AlbumPagePhoto::create([
            'album_page_id' => 5,
            'album_frame_type_id' => 2,
            'sequence' => 10,
            'x_position' => 400,
            'y_position' => 100,
            'rotation' => 0,
            'controls_position' => 'top'
        ]);

        App\AlbumPagePhoto::create([
            'album_page_id' => 5,
            'album_frame_type_id' => 2,
            'sequence' => 11,
            'x_position' => 100,
            'y_position' => 400,
            'rotation' => 0,
            'controls_position' => 'bottom'
        ]);

        App\AlbumPagePhoto::create([
            'album_page_id' => 5,
            'album_frame_type_id' => 2,
            'sequence' => 12,
            'x_position' => 400,
            'y_position' => 400,
            'rotation' => 0,
            'controls_position' => 'bottom'
        ]);

        #endregion

        #region Page 6

        App\AlbumPage::create([
            'album_id' => 1,
            'sequence' => 6,
            'image_path' => '/files/images/albuns/album_1/img_6.png'
        ]);

        App\AlbumPageBackground::create([
            'album_page_id' => 6,
            'width' => 190,
            'height' => 160,
            'x_position' => 30,
            'y_position' => 40,
            'rotation' => 0,
            'controls_position' => 'bottom'
        ]);

        #endregion

        #region Page 7

        App\AlbumPage::create([
            'album_id' => 1,
            'sequence' => 7,
            'image_path' => '/files/images/albuns/album_1/img_7.png'
        ]);

        App\AlbumPagePhoto::create([
            'album_page_id' => 7,
            'album_frame_type_id' => 2,
            'sequence' => 13,
            'x_position' => 100,
            'y_position' => 120,
            'rotation' => 0,
            'controls_position' => 'top'
        ]);

        App\AlbumPagePhoto::create([
            'album_page_id' => 7,
            'album_frame_type_id' => 2,
            'sequence' => 14,
            'x_position' => 100,
            'y_position' => 400,
            'rotation' => 0,
            'controls_position' => 'bottom'
        ]);

        App\AlbumPageBackground::create([
            'album_page_id' => 7,
            'width' => 120,
            'height' => 210,
            'x_position' => 90,
            'y_position' => 0,
            'rotation' => 0,
            'controls_position' => 'right'
        ]);

        #endregion

        #region Page 8

        App\AlbumPage::create([
            'album_id' => 1,
            'sequence' => 8,
            'image_path' => '/files/images/albuns/album_1/img_8.png'
        ]);

        App\AlbumPageBackground::create([
            'album_page_id' => 8,
            'width' => 180,
            'height' => 210,
            'x_position' => 50,
            'y_position' => 0,
            'rotation' => 0,
            'controls_position' => 'right'
        ]);

        #endregion

        #region Page 9

        App\AlbumPage::create([
            'album_id' => 1,
            'sequence' => 9,
            'image_path' => '/files/images/albuns/album_1/img_9.png'
        ]);

        App\AlbumPagePhoto::create([
            'album_page_id' => 9,
            'album_frame_type_id' => 2,
            'sequence' => 15,
            'x_position' => 100,
            'y_position' => 100,
            'rotation' => 0,
            'controls_position' => 'top'
        ]);

        App\AlbumPagePhoto::create([
            'album_page_id' => 9,
            'album_frame_type_id' => 2,
            'sequence' => 16,
            'x_position' => 400,
            'y_position' => 100,
            'rotation' => 0,
            'controls_position' => 'top'
        ]);

        App\AlbumPagePhoto::create([
            'album_page_id' => 9,
            'album_frame_type_id' => 2,
            'sequence' => 17,
            'x_position' => 100,
            'y_position' => 400,
            'rotation' => 0,
            'controls_position' => 'bottom'
        ]);

        App\AlbumPagePhoto::create([
            'album_page_id' => 9,
            'album_frame_type_id' => 2,
            'sequence' => 18,
            'x_position' => 400,
            'y_position' => 400,
            'rotation' => 0,
            'controls_position' => 'bottom'
        ]);

        #endregion

        #region Page 10

        App\AlbumPage::create([
            'album_id' => 1,
            'sequence' => 10,
            'image_path' => '/files/images/albuns/album_1/img_10.png'
        ]);

        App\AlbumPageBackground::create([
            'album_page_id' => 10,
            'width' => 210,
            'height' => 150,
            'x_position' => 0,
            'y_position' => 0,
            'rotation' => 0,
            'controls_position' => 'bottom'
        ]);

        #endregion

        #region Page 11

        App\AlbumPage::create([
            'album_id' => 1,
            'sequence' => 11,
            'image_path' => '/files/images/albuns/album_1/img_11.png'
        ]);

        App\AlbumPagePhoto::create([
            'album_page_id' => 9,
            'album_frame_type_id' => 2,
            'sequence' => 19,
            'x_position' => 100,
            'y_position' => 300,
            'rotation' => 0,
            'controls_position' => 'bottom'
        ]);

        App\AlbumPagePhoto::create([
            'album_page_id' => 9,
            'album_frame_type_id' => 2,
            'sequence' => 20,
            'x_position' => 400,
            'y_position' => 300,
            'rotation' => 0,
            'controls_position' => 'bottom'
        ]);

        #endregion

        #region Page 12

        App\AlbumPage::create([
            'album_id' => 1,
            'sequence' => 12,
            'image_path' => '/files/images/albuns/album_1/img_12.png'
        ]);

        #endregion
    }
}
