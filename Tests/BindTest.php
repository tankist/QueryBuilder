<?php

use Query\QuoteStrategy;
use Query\Expression;
use Query\Criteria;
use Query\Criterion;
use Query\Query;
use Query\SimpleQuoteStrategy;


require_once 'BaseTest.php';

class BindTest extends BaseTest
{

	/**
	 *
	 * @test
	 * @dataProvider getStrategyQuote
	 */
	public function bindAssocIntegers($strategyQuote)
	{
		$query = new Query($strategyQuote);
		$query->from('users')
			->where()->add('user_id', ':idUser', Criterion::EQUAL);

		$ids = array(1, 2, 3);
		foreach ($ids as $id){
			$query->bind(array(':idUser' => $id));
			$this->assertEquals("SELECT * FROM `users` WHERE ( `user_id` = {$id} )", $query->createSql());
		}
	}

	/**
	 *
	 * @test
	 * @dataProvider getStrategyQuote
	 */
	public function bindAssocStrings($strategyQuote)
	{
		$query = new Query($strategyQuote);
		$query->from('systems')
			->where()->add('name', ':so', Criterion::EQUAL);

		$sos = array('linux', 'mac', 'win');
		foreach ($sos as $so){
			$query->bind(array(':so' => $so));
			$this->assertEquals("SELECT * FROM `systems` WHERE ( `name` = '{$so}' )", $query->createSql());
		}
	}

	/**
	 *
	 * @test
	 * @dataProvider getStrategyQuote
	 */
	public function bindAssocArrays(QuoteStrategy $strategyQuote)
	{
		$query = new Query($strategyQuote);
		$query->from('systems')
			->where()->add('name', ':so', Criterion::IN);

		$sos = array(array('linux', 'mac'), array(1, 2), array('win', 'linux'), array(1, 'string'));
		foreach ($sos as $so){
			$query->bind(array(':so' => $so));
			$value = $strategyQuote->quote($so);
			$this->assertEquals("SELECT * FROM `systems` WHERE ( `name` IN ({$value}) )", $query->createSql());
		}
	}

	/**
	 *
	 * @return array
	 */
	public function getStrategyQuote(){
		return array(
			array($this->getZendDbQuoteStrategy()),
			array(new SimpleQuoteStrategy()),
		);
	}


}