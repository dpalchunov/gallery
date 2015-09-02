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
            'see_all_photos_part_label' => 'СМОТРЕТЬ ВСЕ',
            'contact_text' => '
                 <pre >
                    По вопросам сотрудничества, организации концертов, иным вопросам и предложениям обращайтесь:
                    e-mail:          <a href="mailto: stadium-r@gmail.com">stadium-r@gmail.com</a>
                    Антон Мирошкин:   <a href="tel: +7(916)163-18-67">+7(916)163-18-67</a>
                    Пальчунов Денис: <a href="tel: +7(926)739-75-31">+7(926)739-75-31</a>
                </pre>
            ',
            'band_about_denis' => '
                                        <b>Голос Дениса Пальчунова</b> являсь неотемлемой частью композиций группы предоставляет возможность идеям коллектива
                            обрести свободу в привычном человеку языке и добраться
                            до сознания слушателей, вместе с музыкой его вокал единым порывом выталкивает человека из привычного состояния,
                            раскачивает и заставляет двигаться в такт каждого слова. Денис уверен: простые, понятные стихи, пронизительный сфокусированный вокал, то
                            без чего не может прожить ни куплета ни одна музыкальная композиция.
            ',
            'band_about_anton' => '
                            Идейный лидер коллектива <b>Антон Мирошкин</b>.
                            Самая простая мелодия в его руках раскрывается в полную красок
                            живую историю.
                            <b>Электрогитара</b> для Антона не просто музыкальный инструмент,а тонкая нить
                            к человеческим чувствм и эмоциям.
                            Драйв, вот чем по его мнению должна быть наполнена хорошая музыка.
            ',
            'band_about_ruslan' => '
                                        <b>Басгитара</b> <b>Руслана Резниченко</b> будто двигатель реактивного самолета,
                            переполнена энергией, как и сам Руслан. Неудержимой страстью наполнена
                            каждая нота его рычащего инструмента. Сложно понять, как столько жизненнго топлива
                            вмещает в себя этот человек. Только творчество дает ему возможность поделиться
                            с миром переполняющим его чувством... безответственности, безнравственности, безрассудности.
                            Секс, наркотики и рок-н-ролл - три заповеди, которых неустанно придерживается музыкант на своем пути.
            '

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
            'see_all_photos_part_label' => 'SHOW ALL',
            'contact_text' => '
                 <pre >
                    For communication, gigs organization, another requests please contact:
                    e-mail:            <a href="mailto: stadium-r@gmail.com">stadium-r@gmail.com</a>
                    Anton Miroshkin:   <a href="tel: +7(916)163-18-67">+7(916)163-18-67</a>
                    Denis Palchunov:   <a href="tel: +7(926)739-75-31">+7(926)739-75-31</a>
                </pre>
            ',
            'band_about_denis' => '
                            <b>Denis Palchunov vocal</b> is important part of Stadium songs. It gives an opportunity for band music ideas to break free
                            and get to people minds, together with a music his vocal in a single wave pulls you out from an ordinary state, rocks
                            and makes you move rhythmically along the song. Denis sure that no one song can live without simple, clear lyrics and shrill focused vocal.
            ',
            'band_about_anton' => '
                            Thought Leader of the band, <b>Anton Miroshkin</b>.
                            An simplest melody will blossom in his hands like a flower in a bright, full of colors lively tail.
                            <b>Lead guitar</b> is not only a musical instrument for Anton, but a thin thread to the human feelings and emotions.
                            As far as he concerned, drive is that thing than every good song must contain.
            ',
            'band_about_ruslan' => '
                            <b>Base guitar of</b> <b>Ruslan Reznichenko</b> like a jet engine and like Ruslan himself,
                            overfilled by energy. Every note of his rattling guitar overfilled by irresistible passion.
                            It is hard to understand, how this man contains so much fuel of life.
                            Only creation gives him a chance to share his overwelming feelings with the world... feellings of irresponsibility, immorality, folly.
                            There are only three commandments that Ruslan sticks on his track: sex, drugs, and rock-n-roll.
            '



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


