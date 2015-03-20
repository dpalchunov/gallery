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
'РОДИЛАСЬ В ГОРОДЕ ТАРТУ В 1989 ГОДУ.
В 2005 ГОДУ ПОСТУПИЛА В МОСКОВСКОЕ ГОСУДАРСТВЕННОЕ АКАДЕМИЧЕСКОЕ
ХУДОЖЕСТВЕННОЕ УЧИЛИЩЕ ПАМЯТИ 1905 ГОДА.
С 2010 ГОДА ПО НАСТОЯЩЕЕ ВРЕМЯ ЯВЛЯЕТСЯ СТУДЕНТКОЙ МГАХИ ИМ. СУРИКОВА,
МАСТЕРСКОЙ НАРОДНОГО ХУДОЖНИКА, АКАДЕМИКА РАХ, ПРОФЕССОРА ТАТЬЯНЫ НАЗАРЕНКО.
В 2014 ГОДУ НАГРАЖДЕНА ЗОЛОТОЙ МЕДАЛЬЮ РОССИЙСКОЙ АКАДЕМИИ ХУДОЖЕСТВ.
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
'STRUNKOVA KRISTINA. WAS BORN IN TARTU IN 1989.
KRISTINA STUDIED ART AT SCHOOL IN TAMBOV. IN 2005 BEGAN STUDYING AT
MOSCOW STATE ART COLLEGE BY NAME 1905 YEAR AND FINISHED IT IN 2009.
IN THE SAME YEAR SHE BEGAN STUDYING AT MOSCOW STATE ART INSTITUTE
BY NAME OF V.SURIKOV IN THE FACULTY OF PAINTING AND THIS CONTINUES
AT THIS MOMENT.SHE TOOK PART IN SEVERAL EXHIBITIONS IN MOSCOW AND
TAMBOV IN RUSSIA AND ENGLAND.',
            'change_lang_label' => 'рус',
            'contacts_call_comment' => 'Call to mobile phone in Moscow.',
            'contacts_mail_comment' => 'Mail to electronic mail.',
            'contacts_skype_comment' => 'Call in Skype.',
            'contacts_main_phrase' => 'To explore the possibilities for cooperation or art works purchase contact me',
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


