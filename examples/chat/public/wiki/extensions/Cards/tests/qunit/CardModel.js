( function () {
	'use strict';

	var CardModel = mw.cards.CardModel;

	QUnit.module( 'ext.cards.CardModel' );

	QUnit.test( '#set', 1, function ( assert ) {
		var model = new CardModel( {} );

		model.on( 'change', function ( attributes ) {
			assert.strictEqual(
				attributes.foo,
				'bar',
				'It emits an event with the attribute that has changed.'
			);
		} );
		model.set( 'foo', 'bar' );

		model = new CardModel( {} );
		model.on( 'change', function () {
			assert.ok( false, 'It doesn\'t emit an event when silenced.' );
		} );

		model.set( 'foo', 'bar', true );
	} );

	QUnit.test( '#get', 2, function ( assert ) {
		var model = new CardModel( {} );

		model.set( 'foo', 'bar' );
		assert.strictEqual( model.get( 'foo' ), 'bar', 'Got the correct value.' );
		assert.strictEqual( model.get( 'x' ), undefined, 'Got the correct value.' );
	} );
}() );