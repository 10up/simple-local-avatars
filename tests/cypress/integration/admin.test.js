import {deactivatePlugin} from "@10up/cypress-wp-utils/lib/commands/deactivate-plugin";

describe('Admin can login and make sure plugin is activated', () => {
    before(() => {
        cy.login();
    });

    it('Can activate plugin if it is deactivated', () => {
        cy.visitAdminPage("plugins.php");
        cy.get("#deactivate-simple-local-avatars, tr[data-slug=simple-local-avatars] .deactivate a").click();
        cy.get("#activate-simple-local-avatars, tr[data-slug=simple-local-avatars] .activate a").click();
        cy.get("#deactivate-simple-local-avatars, tr[data-slug=simple-local-avatars] .deactivate a").should("be.visible");
    });
});
