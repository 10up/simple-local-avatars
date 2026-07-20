describe("Check avatar on a  post", () => {
  beforeEach(() => {
    cy.login();
  });

  it("Can admin upload, crop and select local avatar?", () => {
    // Check and upload at least one media file.
    cy.atleastOneMedia();

    // Visit profile page and set uploaded file as an avatar.
    cy.visit("/wp-admin/profile.php");
    cy.get("#simple-local-avatar-media").click();

    cy.get(".media-menu-item:nth-child(2)").click();
    cy.get("li.attachment:first-child").click();
    cy.get(".media-button-select").click();

    cy.get("body").then(($body) => {
      if (0 !== $body.find(".media-button-insert").length) {
        cy.get(".media-button-insert").click();
      }
    });

    cy.get("#simple-local-avatar-remove").should("be.visible");
  });

  it("Can admin set the avatar rating?", () => {
    cy.visit("/wp-admin/profile.php");

    cy.get('input[name="simple_local_avatar_rating"][value="PG"]').check();
    cy.get("#description").clear().type("Admin bio");
    cy.get("#submit").click();

    cy.get('input[name="simple_local_avatar_rating"][value="PG"]').should(
      "be.checked"
    );
    cy.get('input[name="simple_local_avatar_rating"][value="G"]').check();
    cy.get("#submit").click();
  });

  it("Does the avatar appear on a created post?", () => {
    // Set the theme
    cy.visit("/wp-admin/themes.php");
    cy.get(".theme-browser.rendered").then(($body) => {
      if (
        0 !==
        $body.find('.theme[data-slug="twentytwentyone"] .button.activate')
          .length
      ) {
        cy.get('.theme[data-slug="twentytwentyone"] .button.activate').click({
          force: true,
        });
      }
    });

    // Use the REST API to create a post so this test is not coupled to
    // block editor UI selectors, which change across WP versions.
    cy.window()
      .its("wpApiSettings.nonce")
      .then((nonce) => {
        cy.request({
          method: "POST",
          url: "/wp-json/wp/v2/posts",
          headers: { "X-WP-Nonce": nonce },
          body: { title: "Test Simple Avatars Post", status: "publish" },
        }).then((response) => {
          cy.visit(`/?p=${response.body.id}`);
          cy.get(".author-bio .avatar").should("be.visible");
          cy.get(".author-bio .avatar")
            .invoke("attr", "src")
            .should("include", "icon-256x256");
        });
      });
  });
});
