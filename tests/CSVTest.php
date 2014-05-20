<?php
namespace mnshankar\CSV;

class CSVTest extends \PHPUnit_Framework_TestCase
{
    public function testArrayConvertedProperlyToCSV()
    {
        //return CSV::with($model)->save(storage_path().'/logs/my.csv');
        $arr = array(
            array('name'=>'name1', 'address'=>'address1'),
            array('name'=>'name2', 'address'=>'address2'),
        );

        $sut = new CSV();
        //ob_start();
        $data =  $sut->with($arr)->setFileHandle()->toString();
        //$data = ob_get_contents();

        $this->assertEquals('name,address
name1,address1
name2,address2
', $data);
    }

    /**
     * @expectedException Exception
     */
    public function testExceptionThrownWhenUnexpectedObjectPassed()
    {
        $sut = new CSV();
        $obj = new \stdClass();
        $row =  $sut->with($obj)->setFileHandle()->getCSV();
    }

    public function testFileReadWithOutHeaderWorksAsExpected()
    {
        $obj = new CSV();
        $data = $obj->with(__DIR__ . '/read_noheader.csv', false)->toString();
        $this->assertEquals($data, 'name1,address1
name2,address2
');
    }

    public function testFileReadWithHeaderWorksAsExpected()
    {
        $obj = new CSV();
        $data = $obj->with(__DIR__ . '/read.csv')->toString();
        $this->assertEquals($data,'column1," ""column2"""
name1,address1
name2,address2
');
    }

	public function testFileReadIsReturnedAsCSV()
	{
		$obj = new CSV();
		$data = $obj->with(__DIR__ . '/read_noheader.csv')->toArray();
		$this->assertEquals($data,array(0=>array('name1'=>'name2',
			'address1'=>'address2')));
	}

    public function testMultiArrayFlattens()
    {
        $obj = new CSV();
        $arr = array(
            array(
                'title' => 'Hello world',
                'comments' => array(
                    array('title' => 'First'),
                    array('title' => 'Second'),
                ),
            )
        );

        $flattened_data = <<<EOL
title,comments.0.title,comments.1.title
"Hello world",First,Second

EOL;

        $data = $obj->with($arr)->setFileHandle()->toString();
        $this->assertEquals($data, $flattened_data);
    }

    public function testMultiArrayFlattensDifferetLengthRows()
    {
        $obj = new CSV();
        $arr = array(
            array(
                'title' => 'Hello world',
                'comments' => array(
                    array('title' => 'First'),
                    array('title' => 'Second'),
                ),
            ),
            array(
                'title' => 'Hello world, again',
                'comments' => array(
                    array('title' => 'First'),
                    array('title' => 'Second'),
                    array('title' => 'Third'),
                ),
            )
        );

        $flattened_data = <<<EOL
title,comments.0.title,comments.1.title,comments.2.title
"Hello world",First,Second
"Hello world, again",First,Second,Third

EOL;

        $data = $obj->with($arr)->setFileHandle()->toString();
        $this->assertEquals($data, $flattened_data);
    }
}
