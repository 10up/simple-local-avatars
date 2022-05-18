// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************
//
//
// -- This is a parent command --
// Cypress.Commands.add('login', (email, password) => { ... })
//
//
// -- This is a child command --
// Cypress.Commands.add('drag', { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add('dismiss', { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This will overwrite an existing command --
// Cypress.Commands.overwrite('visit', (originalFn, url, options) => { ... })

Cypress.Commands.add( 'visitAdminPage', ( page = 'index.php' ) => {
    cy.login();
    if ( page.includes( 'http' ) ) {
        cy.visit( page );
    } else {
        cy.visit( `/wp-admin/${ page.replace( /^\/|\/$/g, '' ) }` );
    }
} );

Cypress.Commands.add( 'atleastOneMedia', ( page = '/wp-admin/upload.php?mode=list' ) => {
    cy.login();
    // Check and upload at least one media file.
    cy.get('body').then($body => {
        if (0 !== $body.find('.no-items').length) {
            cy.visit('/wp-admin/media-new.php?browser-uploader');
            cy.get('#async-upload').attachFile('../../../.wordpress-org/icon-256x256.png');
            cy.get('#html-upload').click();
        }
    });
} );