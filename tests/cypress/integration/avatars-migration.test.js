describe('Avatar migration', () => {
    beforeEach(() => {
        cy.login();
    });

    it('Test "no migration" from WP User Avatar', () => {

        // Visit profile page and perform migration.
        cy.visit('/wp-admin/options-discussion.php');
        cy.get('#simple-local-avatars-migrate-from-wp-user-avatar').click();

        cy.get('.simple-local-avatars-migrate-from-wp-user-avatar-progress').should('contain', 'No avatars were migrated from WP User Avatar.');
    });
});
