<?php   
  class  Localizator {
    private static $rus;
    private static $eng;
    public function __construct() {
      global $rus,$eng;
      $rus = array (
                     'about_main_text'   =>
'Родилась в Тарту в 1989 году. Окончив художественную школу в Тамбове, в 2005 году поступила
в "Московское государственное академическое художественное училище памяти 1905 года".
На этом профессиональный путь молодой художницы не закончился, и в 2009 году Кристина,
успешно пройдя вступительные испытания, была принята в
"Московский государственный академический художественный институт им. В.И. Сурикова”
на живописное отделение в мастерскую Н.А.Дубовика и С.Н. Шильникова.
Принимала участие в государственной выставке молодых художников в г.Коломне,
студентечской выставке МГАХУ памяти 1905 года. 2010 год в жизни художницы был
отмечен летним плейером в Англии, где по его завершении она приняла участие в
выставке в Гастингсе. Работы художницы находятся в частных коллекциях Англии и России.',
                     'about_change_lang' => 'in English',
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
                     'no_results' => 'К сожалению по заданным условиям фильтра не найдено ни одной работы, попробуйте изменить условия.'                     
             
             ) ;
      $eng = array (
                     'about_main_text'   =>
'Strunkova Kristina. Was born in Tartu in 1989. Kristina studied art at school in Tambov.
In 2005 began studying at Moscow State Art College by name 1905 year and finished it in 2009.
In the same year she began studying at Moscow State Art Institute by name of V.Surikov in the
faculty of painting and this continues at this moment. She took part in several exhibitions
in Moscow and Tambov in Russia and England.',
                     'about_change_lang' => 'по-русски',
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
                     'no_results' => 'There is no results. Change filter options.'                      
                           
             ) ;  
    } 
    
    
    public function getText($lang, $label) {
      global $rus,$eng;
      if ($lang == 'rus') {
        return $rus[$label];  
      } else {
        return $eng[$label];         
      }       
    }
  }

  
?>


