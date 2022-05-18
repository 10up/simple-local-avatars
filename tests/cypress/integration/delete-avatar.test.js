import 'cypress-file-upload';

describe('Check if admin can delete avatar', () => {
    before(() => {
        cy.login();
    });

    it('Can admin delete an avatar?', () => {

        // Visit profile page and delete an avatar.
        cy.visit( '/wp-admin/profile.php' );
        cy.get('body').then($body => {
            if (0 !== $body.find('#simple-local-avatar-remove').length) {
                cy.get('#simple-local-avatar-remove').click();
            }
        });

        cy.get( '#simple-local-avatar-remove' ).should( 'not.be.visible' );
    });
});
