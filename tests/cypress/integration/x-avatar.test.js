import 'cypress-file-upload';

describe('Check if admin can delete avatar', () => {
    before(() => {
        cy.login();
    });

    it('Can admin delete an avatar?', () => {

        // Visit profile page and delete an avatar.
        cy.visit('/wp-admin/profile.php');
        cy.get('body').then($body => {
            if (0 !== $body.find('#simple-local-avatar-delete').length) {
                cy.get('#simple-local-avatar-delete').click();
            }
        });

        cy.get('#simple-local-avatar-delete').should('not.be.visible');
    });
});
