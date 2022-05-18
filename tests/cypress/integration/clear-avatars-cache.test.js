describe( 'Check if avatar cache can be cleared', () => {
  before(() => {
    cy.login();
  });

  it('Can admin clear avatar cache?', () => {

    // Visit profile page and clear the avatar cache.
    cy.visit( '/wp-admin/options-discussion.php' );
    cy.get('#clear_cache_btn').click();

    cy.get( '#clear_cache_message' ).should( 'contain', 'Completed' );
  });
} );
