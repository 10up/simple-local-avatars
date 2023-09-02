describe('Admin can login and make sure plugin is activated', () => {
    before(() => {
        cy.login();
    });

    it('Can activate plugin if it is deactivated', () => {
        cy.deactivatePlugin('simple-local-avatars');
        cy.activatePlugin('simple-local-avatars');
    });
});
