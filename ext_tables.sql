CREATE TABLE pages
(
    uniform_product_names_export               varchar(255) DEFAULT '' NOT NULL,
    uniform_product_names_audience             varchar(255) DEFAULT '' NOT NULL,
    uniform_product_names_online_aanvragen     varchar(255) DEFAULT '' NOT NULL,
    uniform_product_names_aanvraag_url         text,
    uniform_product_names_abstract             text,
    uniform_product_names_uniforme_productnaam text,
    uniform_product_names_gerelateerd_product  text,
    uniform_product_names_product_html         text,
    uniform_product_names_language             varchar(255) DEFAULT 'nl' NOT NULL
);

CREATE TABLE tx_pnuniformproductnames_domain_model_uniformeproductnamen
(
    title varchar(255) DEFAULT '' NOT NULL,
    uri   text
);