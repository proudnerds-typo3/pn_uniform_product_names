.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _known-problems:

Known Problems
==============

Never empty the productnames table
----------------------------------

Pages refer to productnames by **uid**: the page properties fields :code:`uniform_product_names_uniforme_productnaam` and :code:`uniform_product_names_gerelateerd_product` store a comma separated list of :code:`tx_pnuniformproductnames_domain_model_uniformeproductnamen.uid` values. There is no MM table and no referential integrity.

So do **not** truncate that table and run the import again to "refresh" it. The import assigns new uids, and after a :code:`TRUNCATE` the auto increment starts at 1 again, so the uids of every page now point at a different productname. Nothing errors: the Samenwerkende Catalogi feed simply publishes the wrong productname for every page: a page about passports ends up offering an unrelated product.

The import itself is safe to run as often as you like. It only inserts productnames that are not in the table yet and never deletes or renumbers anything, so existing relations stay intact.

If the table was emptied anyway, restore it from a backup. Re-importing does not repair the relations, it only makes them look plausible again.

This is maybe an old design flaw: the relation could have used the :code:`uri` field, the national identifier from standaarden.overheid.nl, which is stable across installations and imports. Changing it now means migrating the stored uid lists in :code:`pages`, which would need a future upgrade wizard.


Reporting problems
------------------

https://github.com/proudnerds-typo3/pn_uniform_product_names/issues
