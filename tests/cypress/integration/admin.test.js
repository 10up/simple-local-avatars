describe( 'Admin can login and make sure plugin is activated', () => {
  it( 'Can activate plugin if it is deactivated', () => {
    cy.visitAdminPage( 'plugins.php' );
    cy.get( '#deactivate-simple-local-avatars' ).click();
    cy.get( '#activate-simple-local-avatars' ).click();
    cy.get( '#deactivate-simple-local-avatars' ).should( 'be.visible' );
  } );
} );
