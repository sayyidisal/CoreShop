<?php
/**
 * CoreShop.
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

namespace CoreShop\Model\Carrier\ShippingRule\Condition;

use CoreShop\Exception;
use CoreShop\Model\Carrier\ShippingRule;
use CoreShop\Model\Cart\PriceRule;
use CoreShop\Model\Cart;
use CoreShop\Model\Product as ProductModel;
use CoreShop\Model\CustomerGroup as CustomerGroupModel;
use CoreShop\Model\User;
use CoreShop\Tool;

/**
 * Class CustomerGroups
 * @package CoreShop\Model\PriceRule\Condition
 */
class CustomerGroups extends AbstractCondition
{
    /**
     * @var int[]
     */
    public $customerGroups;

    /**
     * @var string
     */
    public $type = 'customerGroups';

    /**
     * @return int[]
     */
    public function getCustomerGroups()
    {
        return $this->customerGroups;
    }

    /**
     * @param int[] $customerGroups
     */
    public function setCustomerGroups($customerGroups)
    {
        $this->customerGroups = $customerGroups;
    }

    /**
     * Check if Cart is Valid for Condition.
     *
     * @param Cart $cart
     * @param User\Address $address;
     * @param ShippingRule $shippingRule
     *
     * @return mixed
     */
    public function checkCondition(Cart $cart, User\Address $address, ShippingRule $shippingRule) {
        return $this->check(Tool::getUser());
    }

    /**
     * @param User $customer
     * @return bool
     * @throws Exception
     * @throws \Exception
     */
    private function check(User $customer)
    {
        if (!$customer) {
            return false;
        }

        $validCustomerGroupFound = false;

        foreach($this->getCustomerGroups() as $group) {
            foreach ($customer->getGroups() as $customerGroup) {
                $customerGroup = CustomerGroupModel::getByField('name', $customerGroup);

                if ($customerGroup instanceof CustomerGroupModel) {
                    if ($group === $customerGroup->getId()) {
                        $validCustomerGroupFound = true;
                        break;
                    }
                }
            }

            if($validCustomerGroupFound) {
                break;
            }
        }

        if (!$validCustomerGroupFound) {
            return false;
        }

        return true;
    }
}
