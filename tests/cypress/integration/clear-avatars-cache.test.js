describe( 'Check if "Select avatar and Crop" popup appears', () => {
  before(() => {
    cy.login();
  });

  it('Can admin do an avatar migration?', () => {

    // Visit profile page and clear the avatar cache.
    cy.visit( '/wp-admin/options-discussion.php' );
    cy.get('#clear_cache_btn').click();

    cy.get( '#clear_cache_message' ).should( 'contain', 'Completed' );
  });
} );
