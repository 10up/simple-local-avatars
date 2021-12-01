<?php
/**
 * Basic SRM tests
 *
 * @package safe-redirect-manager
 */

/**
 * PHPUnit test class
 */
class BasicTest extends \WPAcceptance\PHPUnit\TestCase {
	/**
	 * @param WPAcceptance\PHPUnit\Actor $actor Actor instance.
	 */
	protected function uploadFile( $actor, $file ) {
		$actor->moveTo( '/wp-admin/media-new.php?browser-uploader' );

		$actor->attachFile( '#async-upload', $file );

		$actor->click( '#html-upload' );

		$actor->waitUntilElementVisible( 'h1.wp-heading-inline' );

		$actor->moveTo( 'wp-admin/upload.php?mode=list' );

		$id = $actor->getElementAttribute( '#the-list tr:first-child', 'id' );

		return str_replace( 'post-', '', $id );
	}

	/**
	 * Home page loads properly
	 */
	public function testHomePageLoads() {
		$I = $this->openBrowserPage();

		$I->moveTo( '/' );

		$I->seeElement( 'body.home' );
	}

	/**
	 * Admin dashboard loads properly
	 */
	public function testAdminLoads() {
		$I = $this->openBrowserPage();

		$I->loginAs( 'admin' );

		$I->seeElement( '#wpadminbar' );
	}

	public function testAdminSettingShows() {
		$I = $this->openBrowserPage();

		$I->loginAs( 'admin' );

		$I->moveTo( 'wp-admin/options-discussion.php' );

		$I->seeText( 'Local Avatars Only' );

		$I->seeText( 'Local Upload Permissions' );

		$I->seeText( 'Migrate Other Local Avatars' );

		$I->moveTo( 'wp-admin/profile.php' );

		$I->seeText( 'Upload Avatar' );
	}

	public function testLocalAvatarShows() {
		$I = $this->openBrowserPage();

		$I->loginAs( 'admin' );

		$avatar_id = $this->uploadFile( $I, dirname( __FILE__ ) . '/file/10up-logo.png' );

		$I->moveTo( 'wp-admin/profile.php' );

		$I->click( '#simple-local-avatar-media' );

		$I->waitUntilElementVisible( '.media-modal' );

		$I->click( '#menu-item-browse' );

		sleep( 1 );

		$I->click( "ul.attachments li[data-id='$avatar_id']" );

		$I->click( '.media-button-select' );

		$I->click( '#submit' );

		$I->moveTo( 'wp-admin/users.php' );

		$source = $I->getPageSource();

		$this->assertContains( '10up-logo', $source );
	}
}
