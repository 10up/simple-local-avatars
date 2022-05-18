import {deactivatePlugin} from "@10up/cypress-wp-utils/lib/commands/deactivate-plugin";

describe('Admin can login and make sure plugin is activated', () => {
    it('Can activate plugin if it is deactivated', () => {
        cy.activatePlugin('simple-local-avatars');
        cy.deactivatePlugin('simple-local-avatars');
    });
});
