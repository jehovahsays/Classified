<?php

/*
	Extension:Moderation - MediaWiki extension.
	Copyright (C) 2014-2016 Edward Chernenko.

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
*/

/**
	@file
	@brief Checks if the user is blacklisted.
*/

class ModerationBlockCheck {
	public static function isModerationBlocked( $user ) {
		$dbw = wfGetDB( DB_MASTER ); # Need actual data
		$blocked = $dbw->selectField( 'moderation_block',
			'mb_id',
			array( 'mb_address' => $user->getName() ),
			__METHOD__
		);
		return $blocked ? true : false;
	}
}
