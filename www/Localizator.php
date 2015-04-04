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
'БИОГРАФИЯ

Родилась в городе Тарту в 1989 году.
В 2005 году поступила в Московское государственное академическое художественное училище памяти 1905 года.
С 2010 года по настоящее время является студенткой МГАХИ им. Сурикова,
 мастерской народного художника, академика РАХ, профессора Татьяны Назаренко.
В 2012 году награждена дипломом им. Коровина  РАХ за портрет на пленере.
В 2014 году награждена золотой медалью Российской Академии Художеств.

2014 Проект «Параллели» EAST MEETS WEST GALLERY, Artplay, Москва (каталог).
2014 Молодежная выставка МОСХ, Москва.
2013 Молодежная выставка МОСХ, Москва.
2013 Молодежная выставка МОСХ, Москва.
2013 Проект «От школы к школе», Галерея «Крыша», Москва.
2013  Проект «Наши первые впечатления» Арт-Салон, ЦДХ, Москва.
2012 Персональная выставка, Областная картинная галерея (катаог), Тамбов.
2010 «Гастингс глазами русских художников» BAKER MAMONOVA GALLERY, Гастингс, Англия.

Работы художницы имеются в частных коллекциях России и за рубежом.
',
            'change_lang_label' => 'eng',
            'contacts_call_comment' => 'Звоните на мой мобильный телефон в Москве.',
            'contacts_mail_comment' => 'Пишите на электронную почту.',
            'contacts_skype_comment' => 'Звоните в скайп.',
            'contacts_main_phrase' => 'По вопросам сотрудничества, приобритения работ обращайтесь:',
            'buy_main_phrase' => 'По вопросам сотрудничества, приобритения работ обращайтесь:',
            'buy_pic' => 'Купите любую из понравившихся вам картину, ценовой диапазон определяется следующим образом:',
            'buy_pic_price1' => 'до пятидесяти тысяч рублей.',
            'buy_pic_price2' => 'до двухсот тысяч рублей.',
            'buy_pic_price3' => 'более двухсот тысяч рублей.',
            'buy_portret' => 'Также вы можете заказать портрет, пейзаж выполненный как маслом на холсте, так и углём на бумаге:',
            'buy_portret_price' => 'условия обговариваются.',
            'no_results' => 'К сожалению по заданным условиям фильтра не найдено ни одной работы, попробуйте изменить условия.',
            'about_label' => 'О ней',
            'contacts_label' => 'Контакты',
            'gallery_label' => 'Галерея',
            'order_label' => 'На заказ'
        );
        $eng = array(
            'about_main_text' =>
'BIOGRAPHY

Born in Tartu in 1989.
2005-entered Moscow Art School by memory of 1905.
2010- present-student at the Surikov State Institute of Fine Arts
(Studio under the guidance of  People’s Artist, Member of the Russian Academy of Arts,
 Professor Tatyana Nazarenko)
2012- awarded by the diploma of the Russian Academy of Fine Arts for the portrait work.
2014- awarded by the gold medal of the Russian Academy of Fine Arts.

2014 Project «Parallels» EAST MEETS WEST GALLERY, Artplay, Moscow (catalog).
2014 The Yong Artists exhibition, Moscow Union of Artists, Moscow
2013 The Yong Artists exhibition, Moscow Union of Artists, Moscow.
2013 The Yong Artists exhibition, Moscow Union of Artists, Moscow.
2013 Project «From school to school «Krisha» Gallery, Moscow.
2013 Moscow Art Saloon, Central House of Artists, Moscow.
2012 Personal Exhibition, Regional picture gallery, Tambov.
2010 «Hastings as seen by the Russian artists», Baker Mamonova Gallery, Hastings, England.

Kristina’s pictures are in private collections in Russia and in Europe.

',
            'change_lang_label' => 'рус',
            'contacts_call_comment' => 'Call to mobile phone in Moscow.',
            'contacts_mail_comment' => 'Mail to electronic mail.',
            'contacts_skype_comment' => 'Call in Skype.',
            'contacts_main_phrase' => 'To explore the possibilities for cooperation or art works purchase contact:',
            'buy_pic' => 'Order any of your favorite painting, near price is:',
            'buy_pic_price1' => 'less than two thousand dollars.',
            'buy_pic_price2' => 'less than five thousand dollars.',
            'buy_pic_price3' => 'bigger than five thousand dollars.',
            'buy_portret' => 'Furthermore, you can order portret, landscape maked in oil on canvas or in charcoal on paper:',
            'buy_portret_price' => 'contractual conditions.',
            'no_results' => 'There is no results. Change filter options.',
            'about_label' => 'About',
            'contacts_label' => 'Contacts',
            'gallery_label' => 'Gallery',
            'order_label' => 'Buy'

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


