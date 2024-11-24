window.onload = function() {
  const urlParams = window.location.href;
  const apiUrl = `${urlParams}/openapi.json`;
  const ui = SwaggerUIBundle({
    url: apiUrl,
    dom_id: '#swagger-ui',
    deepLinking: true,
    presets: [
      SwaggerUIBundle.presets.apis,
      SwaggerUIStandalonePreset
    ],
    layout: "StandaloneLayout"
  });

  window.ui = ui;
};
