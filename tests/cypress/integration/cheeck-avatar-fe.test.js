describe('Check avatar on a  post', () => {
    before(() => {
        cy.login();
    });

    it('Can admin upload, crop and select local avatar?', () => {

        // Check and upload at least one media file.
        cy.atleastOneMedia();

        // Visit profile page and set uploaded file as an avatar.
        cy.visit('/wp-admin/profile.php');
        cy.get('#simple-local-avatar-media').click();

        cy.get('.media-menu-item:nth-child(2)').click();
        cy.get('li.attachment:first-child').click();
        cy.get('.media-button-select').click();

        cy.get('body').then($body => {
            if (0 !== $body.find('.media-button-insert').length) {
                cy.get('.media-button-insert').click();
            }
        });

        cy.get('#simple-local-avatar-remove').should('be.visible');
    });

    it('Can admin set the avatar rating?', () => {
        
        cy.visit('/wp-admin/profile.php');

        cy.get('input[name="simple_local_avatar_rating"][value="PG"]').check();
        cy.get('#description').type('Admin bio');
        cy.get('#submit').click();

        cy.reload();

        cy.get('input[name="simple_local_avatar_rating"][value="PG"]').should('be.checked');
    });

    it('Does the avatar appear on a created post?', () => {

        // Make a new post
        cy.visit('/wp-admin/post-new.php');

        // Add a title to the post
        cy.get('.wp-block-post-title').type('Test Simple Avatars Post');

        // Publish the post
        cy.get('.editor-post-publish-button__button').click();
        cy.get('.editor-post-publish-panel__header-publish-button').click();

        // Set the theme
        cy.visit('/wp-admin/themes.php');
        cy.get('.theme[data-slug="twentytwenty"] .button.activate').click({ force: true });

        // Check the FE
        cy.visit('/test-simple-avatars-post/');
        cy.get('.author-bio .avatar').should('be.visible');
    });
});
