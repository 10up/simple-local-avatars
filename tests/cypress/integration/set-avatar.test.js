import 'cypress-file-upload';

describe('Check if "Select avatar and Crop" popup appears', () => {
    before(() => {
        cy.login();
    });

    it('Can admin open "Select avatar and Crop" popup?', () => {

        // Check and upload at least one media file.
        cy.visit('/wp-admin/upload.php?mode=list');
        cy.get('body').then($body => {
            if (0 !== $body.find('.no-items').length) {
                cy.visit('/wp-admin/media-new.php?browser-uploader');
                cy.get('#async-upload').attachFile('../../../.wordpress-org/icon-256x256.png');
                cy.get('#html-upload').click();
            }
        });

        // Visit profile page and set uploaded file as an avatar.
        cy.visit( '/wp-admin/profile.php' );
        cy.get( '#simple-local-avatar-media' ).click();

        cy.get( '#menu-item-browse' ).click();
        cy.get( 'li.attachment.save-ready:first-child' ).click();
        cy.get( '.media-button-select' ).click();

        cy.get('body').then($body => {
            if (0 !== $body.find('.media-button-insert').length) {
                cy.get('.media-button-insert').click();
            }
        });

        cy.get( '#simple-local-avatar-remove' ).should( 'be.visible' );
    });
});
