/**
 * CoreShop
 *
 * LICENSE
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) 2015-2016 Dominik Pfaffenbauer (https://www.pfaffenbauer.at)
 * @license    https://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
 */

pimcore.registerNS('pimcore.plugin.coreshop.rules.conditions.carriers');

pimcore.plugin.coreshop.rules.conditions.carriers = Class.create(pimcore.plugin.coreshop.rules.conditions.abstract, {

    type : 'carriers',

    getForm : function () {
        var me = this;
        var store = pimcore.globalmanager.get('coreshop_carriers');

        var carriers = {
            fieldLabel: t('coreshop_carrier'),
            typeAhead: true,
            listWidth: 100,
            width : 500,
            store: store,
            displayField: 'name',
            valueField: 'id',
            forceSelection: true,
            multiselect : true,
            triggerAction: 'all',
            name:'carriers',
            maxHeight : 400,
            listeners: {
                beforerender: function () {
                    if (!store.isLoaded() && !store.isLoading())
                        store.load();

                    if (me.data && me.data.carriers)
                        this.setValue(me.data.carriers);
                }
            }
        };

        carriers = new Ext.ux.form.MultiSelect(carriers);

        if (this.data && this.data.carriers) {
            carriers.value = this.data.carriers;
        }

        this.form = new Ext.form.FieldSet({
            items : [
                carriers
            ]
        });

        return this.form;
    }
});
