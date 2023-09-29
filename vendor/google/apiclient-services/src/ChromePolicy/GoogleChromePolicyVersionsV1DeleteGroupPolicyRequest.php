<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

namespace Google\Service\ChromePolicy;

class GoogleChromePolicyVersionsV1DeleteGroupPolicyRequest extends \Google\Model
{
  /**
   * @var string
   */
  public $policySchema;
  protected $policyTargetKeyType = GoogleChromePolicyVersionsV1PolicyTargetKey::class;
  protected $policyTargetKeyDataType = '';

  /**
   * @param string
   */
  public function setPolicySchema($policySchema)
  {
    $this->policySchema = $policySchema;
  }
  /**
   * @return string
   */
  public function getPolicySchema()
  {
    return $this->policySchema;
  }
  /**
   * @param GoogleChromePolicyVersionsV1PolicyTargetKey
   */
  public function setPolicyTargetKey(GoogleChromePolicyVersionsV1PolicyTargetKey $policyTargetKey)
  {
    $this->policyTargetKey = $policyTargetKey;
  }
  /**
   * @return GoogleChromePolicyVersionsV1PolicyTargetKey
   */
  public function getPolicyTargetKey()
  {
    return $this->policyTargetKey;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(GoogleChromePolicyVersionsV1DeleteGroupPolicyRequest::class, 'Google_Service_ChromePolicy_GoogleChromePolicyVersionsV1DeleteGroupPolicyRequest');
