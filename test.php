<?php

require_once 'autoload.php';

use Query\Criterion;
use Query\Query;

$query = Query::create()->addColumn('myColumn', 'alias1')
    ->addColumn('myColumn2')
    ->from('mytable')
    ->innerJoinOn('mytabl2')
        ->add('mytable.id', 'mytabl2.id_2', Criterion::EQUAL, null, Criterion::AS_FIELD)
    ->endJoin()
    ->leftJoinOn('person')
        ->add('person.id', 'user.id_person', Criterion::EQUAL, null, Criterion::AS_FIELD)
    ->endJoin()
    ->where()
        ->add('nivel', '1')
           ->add('nivel', '1')
        ->setOR()
            ->add('nivel', '2')
            ->add('nivel', '2')
            ->setAND()
                ->add('nivel', '3')
                ->add('nivel', '3')
                ->add('nivel', array('linux', 'win', 'mac'))
            ->end()
            ->add('nivel', '2')
            ->add('nivel', '2')
        ->end()
        ->add('nivel', '1')
        ->add('nivel', '1')
    ->endWhere()
    ->addGroupBy('alias1')
    ->having()
        ->add('groupcolumn', '123')
        ->add('group2', '45')
    ->endHaving()
    ->setLimit(1)
    ->addDescendingOrderBy('myColumn2')
;

echo '<pre>';
echo $query->createBeautySql();


