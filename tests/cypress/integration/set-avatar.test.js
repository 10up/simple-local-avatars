describe( 'Check if "Select avatar and Crop" popup appears', () => {
  it( 'Can admin open "Select avatar and Crop" popup?', () => {
    cy.login();
    cy.visit( '/wp-admin/profile.php' );
    cy.get( '#simple-local-avatar-media' ).click();
    cy.get( '#media-frame-title h1' ).should( 'contain.text', 'Select avatar and Crop' );
  } );
} );
