describe( 'Check if admin can choose default avatar', () => {
  before(() => {
    cy.login();
  });

  it('Can admin choose a default avatar?', () => {

    // Check and upload at least one media file.
    cy.visit('/wp-admin/upload.php?mode=list');
    cy.get('body').then($body => {
      if (0 !== $body.find('.no-items').length) {
        cy.visit('/wp-admin/media-new.php?browser-uploader');
        cy.get('#async-upload').attachFile('../../../.wordpress-org/icon-256x256.png');
        cy.get('#html-upload').click();
      }
    });

    // Visit profile page and choose a default avatar.
    cy.visit( '/wp-admin/options-discussion.php' );
    cy.get('#simple-local-avatar-default').click();

    cy.get( '#menu-item-browse' ).click();
    cy.get( 'li.attachment.save-ready:first-child' ).click();
    cy.get( '.media-button-select' ).click();
    cy.get( '#avatar_simple_local_avatar' ).check();
    cy.get( '#submit' ).click();

    cy.get( '#avatar_simple_local_avatar' ).should('be.checked');
  });
} );
