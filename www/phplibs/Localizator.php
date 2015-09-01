<?php
class  Localizator
{
    private static $rus;
    private static $eng;

    public function __construct()
    {
        global $rus, $eng;
        $rus = array(
            'about_main_text' =>
            'Рассказть о группу ну совсем нечего
            </br>
            </br>
            </br>
            </br>
            </br>
            </br>
            </br>
            </br>
            </br>
            </br>
            </br>
            ',
            'change_lang_label' => 'RUS/ENG',
            'contacts_call_comment' => 'Звоните на мой мобильный телефон в Москве.',
            'contacts_mail_comment' => 'Пишите на электронную почту.',
            'contacts_skype_comment' => 'Звоните в скайп.',
            'contacts_main_phrase' => 'По вопросам сотрудничества обращайтесь:',
            'buy_main_phrase' => 'По вопросам сотрудничества обращайтесь:',
            'buy_pic' => 'Купите любую из понравившихся вам картину, ценовой диапазон определяется следующим образом:',
            'buy_pic_price1' => 'до пятидесяти тысяч рублей.',
            'buy_pic_price2' => 'до двухсот тысяч рублей.',
            'buy_pic_price3' => 'более двухсот тысяч рублей.',
            'buy_portret' => 'Также вы можете заказать портрет, пейзаж выполненный как маслом на холсте, так и углём на бумаге:',
            'buy_portret_price' => 'условия обговариваются.',
            'no_results' => 'К сожалению по заданным условиям фильтра не найдено ни одной работы, попробуйте изменить условия.',
            'home_label' => 'ДОМ',
            'band_label' => 'ГРУППА',
            'contact_label' => 'КОНТАКТЫ',
            'music_label' => 'ПЕСНИ',
            'photo_label' => 'ФОТО',
            'lyrics_label' => 'СТИХИ',
            'video_label' => 'ВИДЕО',
            'video_band_title_l' => 'ВИДЕО',
            'see_all_video_part_label' => 'СМОТРЕТЬ ВСЕ',
            'songs_band_title_l' => 'ПЕСНИ',
            'see_all_songs_part_label' => 'СЛУШАТЬ ВСЕ',
            'photo_band_title_l' => 'ФОТО',
            'see_all_photos_part_label' => 'СМОТРЕТЬ ВСЕ'


        );
        $eng = array(
            'about_main_text' =>
            'There is nothing to say about the band
            </br>
            </br>
            </br>
            </br>
            </br>
            </br>
            </br>
            </br>
            </br>
            </br>
            </br>
            ',
            'change_lang_label' => 'RUS/ENG',
            'home_label' => 'HOME',
            'band_label' => 'BAND',
            'contact_label' => 'CONTACT',
            'music_label' => 'MUSIC',
            'photo_label' => 'PHOTO',
            'lyrics_label' => 'LYRICS',
            'video_label' => 'VIDEO',
            'video_band_title_l' => 'VIDEO',
            'see_all_video_part_label' => 'SEE ALL VIDEOS',
            'songs_band_title_l' => 'SONGS',
            'see_all_songs_part_label' => 'ALL MUSIC',
            'photo_band_title_l' => 'PHOTO',
            'see_all_photos_part_label' => 'SHOW ALL'

        );
    }


    public function getText($lang, $label)
    {
        global $rus, $eng;
        if ($lang == 'rus') {
            return $rus[$label];
        } else {
            return $eng[$label];
        }
    }
}


?>


