describe( 'Check if a default avatar can be set', () => {
  before(() => {
    cy.login();
  });

  it('Can admin set a default avatar?', () => {

    // Check and upload at least one media file.
    cy.atleastOneMedia();

    // Visit profile page and choose a default avatar.
    cy.visit( '/wp-admin/options-discussion.php' );
    cy.get('#simple-local-avatar-default').click();

    cy.get( '.media-menu-item:nth-child(2)' ).click();
    cy.get( 'li.attachment.save-ready:first-child' ).click();
    cy.get( '.media-button-select' ).click();
    cy.get( '#avatar_simple_local_avatar' ).check();
    cy.get( '#submit' ).click();

    cy.get( '#avatar_simple_local_avatar' ).should('be.checked');
  });
} );
