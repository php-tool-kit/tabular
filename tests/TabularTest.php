<?php

use PHPUnit\Framework\TestCase;
use function ptk\tabular\check_structure;
use function ptk\tabular\col_names;
use function ptk\tabular\get_col_range;
use function ptk\tabular\get_cols;
use function ptk\tabular\get_line_range;
use function ptk\tabular\get_lines;

/**
 * Testes para ptk\tabular
 *
 * @author Everton
 */
class TabularTest extends TestCase
{

    protected array $sample1 = [
        [
            'id' => 1,
            'name' => 'John',
            'age' => 39
        ],
        [
            'id' => 2,
            'name' => 'Mary',
            'age' => 37
        ],
        [
            'id' => 3,
            'name' => 'Paul',
            'age' => 12
        ]
    ];

    public function testCheckStructure()
    {
        $this->assertTrue(check_structure($this->sample1));
    }

    public function testCheckStructureFailNumOfColumns()
    {
        $sample = $this->sample1;
        unset($sample[1]['name']);
//        print_r($sample);exit();
        $this->expectException(Exception::class);
        $this->assertTrue(check_structure($sample));
    }

    public function testCheckStructureFailTypes()
    {
        $sample = $this->sample1;
        settype($sample[1]['age'], 'string');
//        var_dump($sample);exit();
        $this->expectException(Exception::class);
        $this->assertTrue(check_structure($sample));
    }

    public function testCheckStructureFailNameOfColumns()
    {
        $sample = $this->sample1;
        unset($sample[1]['age']);
        $sample[1]['unknow'] = 37;
//        print_r($sample);exit();
        $this->expectException(Exception::class);
        $this->assertTrue(check_structure($sample));
    }

    public function testColNames()
    {
        $this->assertEquals(array_keys($this->sample1[0]), col_names($this->sample1));
    }

    public function testGetCols()
    {
        $expected = [
            [
                'name' => 'John',
                'age' => 39
            ],
            [
                'name' => 'Mary',
                'age' => 37
            ],
            [
                'name' => 'Paul',
                'age' => 12
            ]
        ];
        $this->assertEquals($expected, get_cols($this->sample1, 'name', 'age'));
    }

    public function testGetOneCol()
    {
        $expected = [
            [
                'name' => 'John'
            ],
            [
                'name' => 'Mary'
            ],
            [
                'name' => 'Paul'
            ]
        ];
        $this->assertEquals($expected, get_cols($this->sample1, 'name'));
    }

    public function testGetColsFail()
    {
        $this->expectException(Exception::class);
        get_cols($this->sample1, 'unknow');
    }

    public function testGetColRange()
    {
        $expected = [
            [
                'name' => 'John',
                'age' => 39
            ],
            [
                'name' => 'Mary',
                'age' => 37
            ],
            [
                'name' => 'Paul',
                'age' => 12
            ]
        ];
        $this->assertEquals($expected, get_col_range($this->sample1, 'name', 'age'));
    }

    public function testGetColRangeFirstOmitted()
    {
        $expected = [
            [
                'id' => 1,
                'name' => 'John'
            ],
            [
                'id' => 2,
                'name' => 'Mary'
            ],
            [
                'id' => 3,
                'name' => 'Paul'
            ]
        ];
        $this->assertEquals($expected, get_col_range($this->sample1, '', 'name'));
    }

    public function testGetColRangeLastOmitted()
    {
        $expected = [
            [
                'name' => 'John',
                'age' => 39
            ],
            [
                'name' => 'Mary',
                'age' => 37
            ],
            [
                'name' => 'Paul',
                'age' => 12
            ]
        ];
        $this->assertEquals($expected, get_col_range($this->sample1, 'name', ''));
    }

    public function testGetColRangeFailOnFirst()
    {
        $this->expectException(Exception::class);
        get_col_range($this->sample1, 'unknow', 'age');
    }

    public function testGetColRangeFailOnLast()
    {
        $this->expectException(Exception::class);
        get_col_range($this->sample1, 'id', 'unknow');
    }
    
    public function testGetColRangeFailFirstGreatThanLast()
    {
        $this->expectException(Exception::class);
        get_col_range($this->sample1, 'age', 'name');
    }

    public function testGetLines()
    {
        $expected = [
            [
                'id' => 1,
                'name' => 'John',
                'age' => 39
            ],
            [
                'id' => 3,
                'name' => 'Paul',
                'age' => 12
            ]
        ];
        $this->assertEquals($expected, get_lines($this->sample1, 0, 2));
    }

    public function testGetLinesFail()
    {
        $this->expectException(Exception::class);
        get_lines($this->sample1, 3);
    }

    public function testGetLineRange()
    {
        $expected = [
            [
                'id' => 2,
                'name' => 'Mary',
                'age' => 37
            ],
            [
                'id' => 3,
                'name' => 'Paul',
                'age' => 12
            ]
        ];
        $this->assertEquals($expected, get_line_range($this->sample1, 1, 2));
    }

    public function testGetLineRangeFirstOmitted()
    {
        $expected = [
            [
                'id' => 1,
                'name' => 'John',
                'age' => 39
            ],
            [
                'id' => 2,
                'name' => 'Mary',
                'age' => 37
            ]
        ];
        $this->assertEquals($expected, get_line_range($this->sample1, 0, 1));
    }
    
    public function testGetLineRangeLastOmitted()
    {
        $expected = [
            [
                'id' => 2,
                'name' => 'Mary',
                'age' => 37
            ],
            [
                'id' => 3,
                'name' => 'Paul',
                'age' => 12
            ]
        ];
        $this->assertEquals($expected, get_line_range($this->sample1, 1, 0));
    }
    
    public function testGetLinesFailOnFirst()
    {
        $this->expectException(Exception::class);
        get_line_range($this->sample1, 4, 6);
    }
    
    public function testGetLinesFailOnLast()
    {
        $this->expectException(Exception::class);
        get_line_range($this->sample1, 0, 4);
    }
    
    public function testGetLinesFailFirstGreaterThanLast()
    {
        $this->expectException(Exception::class);
        get_line_range($this->sample1, 2, 1);
    }
}
