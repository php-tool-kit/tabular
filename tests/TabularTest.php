<?php

use PHPUnit\Framework\TestCase;
use function ptk\tabular\check_structure;
use function ptk\tabular\col_names;
use function ptk\tabular\del_cols;
use function ptk\tabular\del_lines;
use function ptk\tabular\duplicates;
use function ptk\tabular\filter;
use function ptk\tabular\get_col_range;
use function ptk\tabular\get_cols;
use function ptk\tabular\get_line_range;
use function ptk\tabular\get_lines;
use function ptk\tabular\map_cols;
use function ptk\tabular\map_rows;
use function ptk\tabular\merge_cols;
use function ptk\tabular\merge_lines;
use function ptk\tabular\read_csv;
use function ptk\tabular\seek;
use function ptk\tabular\set_col_names;
use function ptk\tabular\sort;
use function ptk\tabular\sum_cols;
use function ptk\tabular\sum_lines;
use function ptk\tabular\write_csv;

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
    protected array $sample4 = [
        [
            'field1' => 1,
            'field2' => 10
        ],
        [
            'field1' => 2,
            'field2' => 20
        ],
        [
            'field1' => 3,
            'field2' => 30
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

    public function testColNamesEmpty()
    {
        $this->assertEquals([], col_names([]));
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

    public function testSort()
    {
        $expected = array(
            0 =>
            array(
                'id' => 2,
                'name' => 'Mary',
                'age' => 37,
                'sex' => 'f',
                'adult' => true,
            ),
            1 =>
            array(
                'id' => 3,
                'name' => 'Paul',
                'age' => 12,
                'sex' => 'm',
                'adult' => false,
            ),
            2 =>
            array(
                'id' => 1,
                'name' => 'John',
                'age' => 39,
                'sex' => 'm',
                'adult' => true,
            ),
        );
        $data = merge_cols($this->sample1, $this->sample3);
        $this->assertEquals($expected, sort($data, [
            'sex' => SORT_ASC,
            'id' => SORT_DESC
        ]));
    }

    public function testSortFail()
    {
        $this->expectException(Exception::class);
        sort($this->sample1, ['unknow' => SORT_ASC]);
    }

    public function testFilter()
    {
        $filter = function(array $line): bool {
            if ($line['age'] > 20) {
                return true;
            }
            return false;
        };

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
        $this->assertEquals($expected, filter($this->sample1, $filter));
    }

    public function testFilterNoReindex()
    {
        $filter = function(array $line): bool {
            if ($line['id'] === 2) {
                return true;
            }
            return false;
        };

        $expected = [
            1 => [
                'id' => 2,
                'name' => 'Mary',
                'age' => 37
            ]
        ];
        $this->assertEquals($expected, filter($this->sample1, $filter, false));
    }

    public function testReadCsv()
    {
        $handle = fopen('./tests/assets/sample.csv', 'r');

        $this->assertEquals($this->sample1, read_csv($handle, ';'));
    }

    public function testReadCsvNoHead()
    {
        $handle = fopen('./tests/assets/sample_1.csv', 'r');
        $expected = [
            [1, 'John', 39],
            [2, 'Mary', 37],
            [3, 'Paul', 12]
        ];

        $this->assertEquals($expected, read_csv($handle, ';', false));
    }

    public function testReadCsvSkipLines()
    {
        $handle = fopen('./tests/assets/sample_2.csv', 'r');

        $this->assertEquals($this->sample1, read_csv($handle, ';', true, 2));
    }

    public function testReadCsvNoHeadAndSkipLines()
    {
        $handle = fopen('./tests/assets/sample_3.csv', 'r');
        $expected = [
            [1, 'John', 39],
            [2, 'Mary', 37],
            [3, 'Paul', 12]
        ];

        $this->assertEquals($expected, read_csv($handle, ';', false, 2));
    }

    public function testWriteCsv()
    {
        $filename = './tests/assets/output1.csv';
        $handle = fopen($filename, 'w');
        write_csv($handle, $this->sample1, ';');
        fclose($handle);

        $handle = fopen($filename, 'r');
        $this->assertEquals($this->sample1, read_csv($handle, ';'));
    }

    public function testWriteCsvNoHead()
    {
        $filename = './tests/assets/output2.csv';
        $handle = fopen($filename, 'w');
        write_csv($handle, $this->sample1, ';', false);
        fclose($handle);

        $handle = fopen($filename, 'r');
        $expected = [
            [1, 'John', 39],
            [2, 'Mary', 37],
            [3, 'Paul', 12]
        ];
        $this->assertEquals($expected, read_csv($handle, ';', false));
    }

    public function testSeek()
    {
        $filter = function(array $line): bool {
            if ($line['age'] > 20) {
                return true;
            }
            return false;
        };

        $expected = [0, 1];
        $this->assertEquals($expected, seek($this->sample1, $filter));
    }

    public function testDuplicatesWithTypeTest()
    {

        $data = [
            [1, 2, 3],
            [2, 3, 4],
            [3, 4, 5],
            [4, 5, 6],
            ["1", 2, 3],
            [1, 2, 3],
            [4, 5, 6]
        ];

        $expected = [
            0 => [5],
            3 => [6]
        ];

        $this->assertEquals($expected, duplicates($data));
    }

    public function testDuplicatesNoTypeTest()
    {

        $data = [
            [1, 2, 3],
            [2, 3, 4],
            [3, 4, 5],
            [4, 5, 6],
            ["1", 2, 3],
            [1, 2, 3],
            [4, 5, 6]
        ];

        $expected = [
            0 => [4, 5],
            3 => [6]
        ];

        $this->assertEquals($expected, duplicates($data, false));
    }

    public function testSumCols()
    {
        $this->assertEquals([
            'field1' => 6
            ], sum_cols($this->sample4, 'field1'));
    }

    public function testSumColsFail()
    {
        $this->expectException(Exception::class);
        sum_cols($this->sample4, 'unknow');
    }

    public function testSetColNames()
    {
        $col_names = [
            'codigo',
            'nome',
            'idade'
        ];
        $data = set_col_names($this->sample1, ...$col_names);

        $this->assertEquals($col_names, col_names($data));
    }

    public function testSetColNamesFail()
    {
        $col_names = [
            'codigo',
            'idade'
        ];
        $this->expectException(Exception::class);
        $data = set_col_names($this->sample1, ...$col_names);
    }

    public function testSumLines()
    {
        $data = [
            [
                'f1' => 1,
                'f2' => 10
            ],
            [
                'f1' => 2,
                'f2' => 20
            ],
            [
                'f1' => 3,
                'f2' => 30
            ]
        ];
        $this->assertEquals([['total' => 11], ['total' => 22], ['total' => 33]], sum_lines($data, 'total', 'f1', 'f2'));
    }

    public function testSumLinesFail()
    {
        $data = [
            [
                'f1' => 1,
                'f2' => 10
            ],
            [
                'f1' => 2,
                'f2' => 20
            ],
            [
                'f1' => 3,
                'f2' => 30
            ]
        ];
        $this->expectException(Exception::class);
        sum_lines($data, 'total', 'f1', 'unknow');
    }

    public function testMapRows()
    {
        $mapfn = function($line) {
            $info = "My name is {$line['name']} and I am {$line['age']} years old.";
            return array_merge($line, ['info' => $info]);
        };

        $expected = [
            [
                'id' => 1,
                'name' => 'John',
                'age' => 39,
                'info' => 'My name is John and I am 39 years old.'
            ],
            [
                'id' => 2,
                'name' => 'Mary',
                'age' => 37,
                'info' => 'My name is Mary and I am 37 years old.'
            ],
            [
                'id' => 3,
                'name' => 'Paul',
                'age' => 12,
                'info' => 'My name is Paul and I am 12 years old.'
            ]
        ];

        $this->assertEquals($expected, map_rows($this->sample1, $mapfn));
    }
    
    public function testMapCols()
    {
        $mapfn = function($cell) {
            return strtoupper($cell);
        };

        $expected = [
            [
                'id' => 1,
                'name' => 'JOHN',
                'age' => 39
            ],
            [
                'id' => 2,
                'name' => 'MARY',
                'age' => 37
            ],
            [
                'id' => 3,
                'name' => 'PAUL',
                'age' => 12
            ]
        ];

        $this->assertEquals($expected, map_cols($this->sample1, $mapfn, 'name'));
    }
    
    public function testMapColsFail()
    {
        $mapfn = function($cell) {
            return strtoupper($cell);
        };

        $expected = [
            [
                'id' => 1,
                'name' => 'JOHN',
                'age' => 39
            ],
            [
                'id' => 2,
                'name' => 'MARY',
                'age' => 37
            ],
            [
                'id' => 3,
                'name' => 'PAUL',
                'age' => 12
            ]
        ];

        $this->expectException(Exception::class);
        map_cols($this->sample1, $mapfn, 'unknow');
    }
}
