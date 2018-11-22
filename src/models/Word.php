<?php
namespace Bot\Models;
class Word {
    /**
     * @return array
     */
    private function explodeData() : array  {
        $data = 'Cardamom
Cucumber
Chamomile
Mint
Zest
Cloves
Rosemary
Pomegranate
Golden caster sugar
Cinnamon
Peppercorns
Vinegar
Sparkling water
Thyme
Redcurrants
Cauliflower
Courgettes
Muscovado
Basil
Turmeric
Кардамон
Огурец
ромашка
мята
цедра
гвоздика
Розмарин
Гранат
золотая сахарная пудра
корица
Перец
Уксус
Газированная вода
Тимьян
Красная смородина
Цветная капуста
Кабачки
неочищенный тростниковый сахар
базилик
куркума';
        $dataArray = explode("\n",$data);
        foreach ($dataArray as &$item) {
            $item = trim( $item );
        }
        unset( $data );

        $len = count( $dataArray );
        $result = [];
        if ( $len % 2 == 0 ) {

            $dataSplitted = [
                'en' =>  array_slice($dataArray,0,$len/2 ),
                'ru'  => array_slice( $dataArray, $len/2, $len/2 )
            ];
            unset( $dataArray );

            foreach ( $dataSplitted['en'] as $i => $word ) {
                $result []= [
                    'en' => $word,
                    'ru' => $dataSplitted['ru'][$i]
                ];
            }
        }

        return $result;
    }

    /**
     * @return array
     */
    function getAll() : array {
        return $this->explodeData();
    }

    /**
     * @param int $number
     * @return array
     */
    function getOne(int $number ) : array  {
        $data = $this->getAll();
        if ( count( $data ) > $number ) {
            return $data[$number];
        }
        return [];
    }

    /**
     * @return array
     */
    function getRandom () {
        $data = $this->getAll();
        $rand = rand(0,count($data)-1);
        return ['id'=>$rand,'data'=>$data[$rand]];
    }
}