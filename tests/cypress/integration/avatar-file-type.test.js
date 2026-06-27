import 'cypress-file-upload';

describe('Avatar upload file-type validation', () => {
    beforeEach(() => {
        cy.login();
        cy.visit('/wp-admin/profile.php');
    });

    it('Rejects a non-image file and tells the user why', () => {
        cy.get('#simple-local-avatar').attachFile({
            fileContent: 'not really an image',
            fileName: 'not-an-image.txt',
            mimeType: 'text/plain',
        });

        // The selection is cleared and the rejection is surfaced.
        cy.get('#simple-local-avatar').should('have.value', '');
        cy.get('#simple-local-avatar-error').should('be.visible');
    });

    it('Rejects a file with no detectable MIME type', () => {
        // A renamed binary the browser cannot identify reports an empty type.
        cy.get('#simple-local-avatar').attachFile({
            fileContent: 'renamed binary, no type',
            fileName: 'mystery.bin',
            mimeType: '',
        });

        cy.get('#simple-local-avatar').should('have.value', '');
        cy.get('#simple-local-avatar-error').should('be.visible');
    });

    it('Accepts a valid image and shows no error', () => {
        cy.get('#simple-local-avatar').attachFile('../../../.wordpress-org/icon-256x256.png');

        cy.get('#simple-local-avatar-error').should('not.exist');
        cy.get('#simple-local-avatar').should('not.have.value', '');
    });
});
