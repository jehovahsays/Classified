<?php

use GeoData\Coord;
use GeoData\Globe;
use GeoData\Math;

/**
 * @todo: More tests
 * @group GeoData
 */
class CoordTest extends MediaWikiTestCase {
	/**
	 * @dataProvider getEqualsCases
	 * @param Coord $coord1
	 * @param Coord $coord2
	 * @param bool $matchExpected
	 * @param string $msg
	 */
	public function testEquals( $coord1, $coord2, $matchExpected, $msg = '' ) {
		$this->assertEquals( $matchExpected, $coord1->equalsTo( $coord2 ), $msg );
		if ( $coord2 ) {
			$this->assertEquals( $matchExpected, $coord2->equalsTo( $coord1 ), $msg );
		}
	}

	public function getEqualsCases() {
		return [
			[ new Coord( 10, 20 ), new Coord( 10, 20 ), true, 'Basic equality' ],
			[ new Coord( 10, 20 ), new Coord( 0, 0 ), false, 'Basic inequality' ],
			[ new Coord( 10, 20, 'endor' ), new Coord( 10, 20, 'endor' ), true, 'Equality with globe set' ],
			[ new Coord( 10, 20, 'earth' ), new Coord( 10, 20, 'moon' ), false, 'Inequality due to globe' ],
			[ new Coord( 10, 20, 'yavin' ), new Coord( 0, 0, 'yavin' ), false, 'Inequality with globes equal' ],
			[ new Coord( 10, 20 ), new Coord( 10, 20.1 ), false, 'Precision 1' ],
			[ new Coord( 10, 20 ), new Coord( 10, 20.0000001 ), true, 'Precision 2' ],
			[ new Coord( 10, 20 ), null, false, 'Comparison with null' ],
		];
	}

	public function testBboxAround() {
		for ( $i = 0; $i < 90; $i += 5 ) {
			$coord = new Coord( $i, $i );
			$bbox = $coord->bboxAround( 5000 );
			$this->assertEquals( 10000, Math::distance( $bbox->lat1, $i, $bbox->lat2, $i ), 'Testing latitude', 1 );
			$this->assertEquals( 10000, Math::distance( $i, $bbox->lon1, $i, $bbox->lon2 ), 'Testing longitude', 1 );
		}
	}

	/**
	 * @dataProvider provideGlobeObj
	 */
	public function testGlobeObj( $name, Globe $expected ) {
		$c = new Coord( 10, 20, $name );
		$this->assertTrue( $expected->equalsTo( $c->getGlobeObj() ) );
	}

	public function provideGlobeObj() {
		return [
			[ null, new Globe( 'earth' ) ],
			[ 'earth', new Globe( 'earth' ) ],
			[ 'moon', new Globe( 'moon' ) ],
			[ 'something nonexistent', new Globe( 'something nonexistent' ) ],
		];
	}
}