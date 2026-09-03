describe('Avatar upload file-type validation', () => {
    beforeEach(() => {
        // Admins get the media-library uploader; the plain file input this suite
        // exercises only renders for users without the upload_files capability.
        cy.login('subscriber', 'password');
        cy.visit('/wp-admin/profile.php');
    });

    it('Rejects a non-image file and tells the user why', () => {
        cy.get('#simple-local-avatar').selectFile({
            contents: Cypress.Buffer.from('not really an image'),
            fileName: 'not-an-image.txt',
            mimeType: 'text/plain',
        });

        // The selection is cleared and the rejection is surfaced.
        cy.get('#simple-local-avatar').should('have.value', '');
        cy.get('#simple-local-avatar-error').should('be.visible');
    });

    it('Rejects a file with no detectable MIME type', () => {
        // A renamed binary the browser cannot identify reports an empty type.
        cy.get('#simple-local-avatar').selectFile({
            contents: Cypress.Buffer.from('renamed binary, no type'),
            fileName: 'mystery.bin',
            mimeType: '',
        });

        cy.get('#simple-local-avatar').should('have.value', '');
        cy.get('#simple-local-avatar-error').should('be.visible');
    });

    it('Accepts a valid image and shows no error', () => {
        // Minimal 1x1 PNG; the guard only inspects the reported MIME type.
        cy.get('#simple-local-avatar').selectFile({
            contents: Cypress.Buffer.from(
                'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==',
                'base64'
            ),
            fileName: 'avatar.png',
            mimeType: 'image/png',
        });

        cy.get('#simple-local-avatar-error').should('not.exist');
        cy.get('#simple-local-avatar').should('not.have.value', '');
    });
});
