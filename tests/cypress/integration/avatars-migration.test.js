describe('Check if avatar migration works', () => {
    before(() => {
        cy.login();
    });

    it('Can admin do an avatar migration?', () => {

        // Visit profile page and perform migration.
        cy.visit('/wp-admin/options-discussion.php');
        cy.get('#simple-local-avatars-migrate-from-wp-user-avatar').click();

        cy.get('.simple-local-avatars-migrate-from-wp-user-avatar-progress').should('contain', 'No avatars were migrated from WP User Avatar.');
    });
});
