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
'Ро.дилась в городе Тарту в 1989 году.
В 2005 году поступила в Московское государственное академическое
художественное училище памяти 1905 года.
С 2010 года по настоящее время является студенткой МГАХИ им. Сурикова,
мастерской народного художника, академика РАХ, профессора Татьяны Назаренко.
В 2014 году награждена золотой медалью Российской Академии Художеств.',
            'change_lang_label' => 'eng',
            'contacts_call_comment' => 'Звоните на мой мобильный телефон в Москве.',
            'contacts_mail_comment' => 'Пишите на электронную почту.',
            'contacts_skype_comment' => 'Звоните в скайп.',
            'contacts_main_phrase' => 'По вопросам приобретения картин, заказа портретов и иным вопросам:',
            'buy_main_phrase' => 'По вопросам приобретения картин, заказа портретов и иным вопросам:',
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
'Strunkova Kristina. Was born in Tartu in 1989.
Kristina studied art at school in Tambov. In 2005 began studying at
Moscow State Art College by name 1905 year and finished it in 2009.
In the same year she began studying at Moscow State Art Institute
by name of V.Surikov in the faculty of painting and this continues
at this moment.She took part in several exhibitions in Moscow and
Tambov in Russia and England.',
            'change_lang_label' => 'рус',
            'contacts_call_comment' => 'Call to mobile phone in Moscow.',
            'contacts_mail_comment' => 'Mail to electronic mail.',
            'contacts_skype_comment' => 'Call in Skype.',
            'contacts_main_phrase' => 'If you want to buy painting, order some portret or have another idea:',
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


