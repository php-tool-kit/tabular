<?php

use PHPUnit\Framework\TestCase;
use function ptk\tabular\check_structure;
use function ptk\tabular\col_names;
use function ptk\tabular\del_cols;
use function ptk\tabular\del_lines;
use function ptk\tabular\get_col_range;
use function ptk\tabular\get_cols;
use function ptk\tabular\get_line_range;
use function ptk\tabular\get_lines;
use function ptk\tabular\merge_cols;
use function ptk\tabular\merge_lines;

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
    protected array $sample2 = [
        [
            'id' => 1,
            'name' => 'Matt',
            'age' => 20
        ],
        [
            'id' => 2,
            'name' => 'Anne',
            'age' => 25
        ],
        [
            'id' => 3,
            'name' => 'Joe',
            'age' => 30
        ]
    ];
    protected array $sample3 = [
        [
            'sex' => 'm',
            'adult' => true
        ],
        [
            'sex' => 'f',
            'adult' => true
        ],
        [
            'sex' => 'm',
            'adult' => false
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

    public function testMergeLines()
    {
        $this->assertEquals(array_merge($this->sample1, $this->sample2), merge_lines($this->sample1, $this->sample2));
    }

    public function testMergeLinesFailNumCols()
    {
        $this->expectException(Exception::class);
        merge_lines($this->sample1, [
            [
                'name' => 'Matt',
                'age' => 20
            ],
            [
                'name' => 'Anne',
                'age' => 25
            ],
            [
                'name' => 'Joe',
                'age' => 30
            ]
        ]);
    }

    public function testMergeLinesFailNameCols()
    {
        $this->expectException(Exception::class);
        merge_lines($this->sample1, [
            [
                'cod' => 1,
                'name' => 'Matt',
                'age' => 20
            ],
            [
                'cod' => 2,
                'name' => 'Anne',
                'age' => 25
            ],
            [
                'cod' => 3,
                'name' => 'Joe',
                'age' => 30
            ]
        ]);
    }

    public function testMergeCols()
    {
        $expected = [
            [
                'id' => 1,
                'name' => 'John',
                'age' => 39,
                'sex' => 'm',
                'adult' => true
            ],
            [
                'id' => 2,
                'name' => 'Mary',
                'age' => 37,
                'sex' => 'f',
                'adult' => true
            ],
            [
                'id' => 3,
                'name' => 'Paul',
                'age' => 12,
                'sex' => 'm',
                'adult' => false
            ]
        ];
        $this->assertEquals($expected, merge_cols($this->sample1, $this->sample3));
    }

    public function testMergeColsFailNumLines()
    {
        $this->expectException(Exception::class);
        merge_cols($this->sample1, []);
    }

    public function testDelLines()
    {
        $expected = [
            [
                'id' => 2,
                'name' => 'Mary',
                'age' => 37
            ]
        ];
        $this->assertEquals($expected, del_lines($this->sample1, 0, 2));
    }

    public function testDelLinesFail()
    {
        $this->expectException(Exception::class);
        del_lines($this->sample1, 5);
    }

    public function testDelCols()
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
        $this->assertEquals($expected, del_cols($this->sample1, 'id', 'age'));
    }
    
    public function testDelColsFail()
    {
        $this->expectException(Exception::class);
        del_cols($this->sample1, 'unknow');
    }
}
