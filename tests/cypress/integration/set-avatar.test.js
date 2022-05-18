import 'cypress-file-upload';

describe('Check if admin can upload, crop and select local avatar', () => {
    before(() => {
        cy.login();
    });

    it('Can admin upload, crop and select local avatar?', () => {

        // Check and upload at least one media file.
        cy.atleastOneMedia();

        // Visit profile page and set uploaded file as an avatar.
        cy.visit( '/wp-admin/profile.php' );
        cy.get( '#simple-local-avatar-media' ).click();

        cy.get( '.media-menu-item:nth-child(2)' ).click();
        cy.get( 'li.attachment:first-child' ).click();
        cy.get( '.media-button-select' ).click();

        cy.get('body').then($body => {
            if (0 !== $body.find('.media-button-insert').length) {
                cy.get('.media-button-insert').click();
            }
        });

        cy.get( '#simple-local-avatar-remove' ).should( 'be.visible' );
    });
});
