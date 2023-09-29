<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit') }} <?=$api->name?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('admin/settings/integrations/'.$api->id) }}" class="js-edit-payment">
                @csrf
                <div class="modal-body">
                    <?php if($api->name == 'Stripe') {?>
                    <div class="row">
                        <div class="col-md-4">
                            <h5 class="mb-0">{{ __('Publishable Key') }}</h5>
                            <small>{{ __('Stripe publishable key') }}</small>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control" name="publishable_key" placeholder="{{ __('Publishable key') }}" 
                                        value="<?= $is_serialized !== false ? isset($is_serialized['publishable_key']) ?  $is_serialized['publishable_key'] : '' : ''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <h5 class="mb-0">{{ __('Secret Key') }}</h5>
                            <small>{{ __('Stripe secret key') }}</small>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control" name="secret_key" placeholder="{{ __('Secret Key') }}" 
                                        value="<?= $is_serialized !== false ? isset($is_serialized['secret_key']) ?  $is_serialized['secret_key'] : '' : ''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <h5 class="mb-0">{{ __('Webhook Secret') }}</h5>
                            <small>{{ __('Webhook Secret') }}</small>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control" name="webhook_secret" placeholder="{{ __('Webhook Secret') }}" 
                                        value="<?= $is_serialized !== false ? isset($is_serialized['webhook_secret']) ?  $is_serialized['webhook_secret'] : '' : ''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }?>

                    <?php if($api->name == 'PayPal') {?>
                    <div class="row">
                        <div class="col-md-4">
                            <h5 class="mb-0">{{ __('Client ID') }}</h5>
                            <small>{{ __('Paypal client id') }}</small>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control" name="client_id" placeholder="{{ __('Client ID') }}" 
                                        value="<?= $is_serialized !== false ? isset($is_serialized['client_id']) ?  $is_serialized['client_id'] : '' : ''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <h5 class="mb-0">{{ __('Secret') }}</h5>
                            <small>{{ __('PayPal secret') }}</small>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control" name="secret" placeholder="{{ __('Secret') }}"
                                        value="<?= $is_serialized !== false ? isset($is_serialized['secret']) ?  $is_serialized['secret'] : '' : ''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <h5 class="mb-0">{{ __('Mode') }}</h5>
                            <small>{{ __('Either sandbox or live') }}</small>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <select class="form-control" name="mode">
                                        <option value="">{{ __('Select Here') }}</option>
                                        <option value="sandbox" <?= $is_serialized !== false ? $is_serialized['mode'] == 'sandbox' ? 'selected' : '' : ''?>>{{ __('Sandbox') }}</option>
                                        <option value="live" <?= $is_serialized !== false ? $is_serialized['mode'] == 'live' ? 'selected' : '' : ''?>>{{ __('Live') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <h5 class="mb-0">{{ __('Webhook') }}</h5>
                            <small>{{ __('PayPal webhook Id') }}</small>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control" name="webhook_id" placeholder="{{ __('Webhook') }}"
                                        value="<?= $is_serialized !== false ? isset($is_serialized['webhook_id']) ?  $is_serialized['webhook_id'] : '' : ''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }?>

                    <?php if($api->name == 'Paystack') {?>
                    <div class="row">
                        <div class="col-md-4">
                            <h5 class="mb-0">{{ __('Secret Key') }}</h5>
                            <small>{{ __('Paystack secret key') }}</small>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control" name="secret_key" placeholder="{{ __('Secret Key') }}" 
                                        value="<?= $is_serialized !== false ? isset($is_serialized['secret_key']) ?  $is_serialized['secret_key'] : '' : ''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <h5 class="mb-0">{{ __('Public Key') }}</h5>
                            <small>{{ __('Paystack public key') }}</small>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control" name="public_key" placeholder="{{ __('Public Key') }}"
                                        value="<?= $is_serialized !== false ? isset($is_serialized['public_key']) ?  $is_serialized['public_key'] : '' : ''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }?>

                    <?php if($api->name == 'Coinbase') {?>
                    <div class="row">
                        <div class="col-md-4">
                            <h5 class="mb-0">{{ __('API Key') }}</h5>
                            <small>{{ __('Api Key') }}</small>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control" name="api_key" placeholder="{{ __('API Key') }}" 
                                        value="<?= $is_serialized !== false ? isset($is_serialized['api_key']) ?  $is_serialized['api_key'] : '' : ''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <h5 class="mb-0">{{ __('Webhook Shared Secret') }}</h5>
                            <small>{{ __('Webhook Shared Secret') }}</small>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control" name="webhook_key" placeholder="{{ __('Webhook Key') }}"
                                        value="<?= $is_serialized !== false ? isset($is_serialized['webhook_key']) ?  $is_serialized['webhook_key'] : '' : ''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }?>

                    <?php if($api->name == 'RazorPay') {?>
                    <div class="row">
                        <div class="col-md-4">
                            <h5 class="mb-0">{{ __('Public Key') }}</h5>
                            <small>{{ __('Public Key') }}</small>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control" name="public_key" placeholder="{{ __('Public Key') }}" 
                                        value="<?= $is_serialized !== false ? isset($is_serialized['public_key']) ?  $is_serialized['public_key'] : '' : ''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <h5 class="mb-0">{{ __('Secret Key') }}</h5>
                            <small>{{ __('Secret Key') }}</small>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control" name="secret_key" placeholder="{{ __('Secret Key') }}"
                                        value="<?= $is_serialized !== false ? isset($is_serialized['secret_key']) ?  $is_serialized['secret_key'] : '' : ''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <h5 class="mb-0">{{ __('Webhook Secret') }}</h5>
                            <small>{{ __('Webhook Secret') }}</small>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control" name="webhook_secret" placeholder="{{ __('Webhook Secret') }}"
                                        value="<?= $is_serialized !== false ? isset($is_serialized['webhook_secret']) ?  $is_serialized['webhook_secret'] : '' : ''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }?>

                    <?php if($api->name == 'Google') {?>
                    <div class="row">
                        <div class="col-md-4">
                            <h5 class="mb-0">{{ __('Client ID') }}</h5>
                            <small>{{ __('Google Client ID') }}</small>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control" name="client_id" placeholder="{{ __('Client ID') }}"
                                        value="<?= $is_serialized !== false ? isset($is_serialized['client_id']) ?  $is_serialized['client_id'] : '' : ''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <h5 class="mb-0">{{ __('Client Secret') }}</h5>
                            <small>{{ __('Google Client Secret') }}</small>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control" name="client_secret" placeholder="{{ __('Client Secret') }}"
                                        value="<?= $is_serialized !== false ? isset($is_serialized['client_secret']) ? $is_serialized['client_secret'] : '' : ''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                    
                    <?php if($api->name == 'Facebook') {?>
                    <div class="row">
                        <div class="col-md-4">
                            <h5 class="mb-0">{{ __('Client ID') }}</h5>
                            <small>{{ __('Facebook Client ID') }}</small>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control" name="client_id" placeholder="{{ __('Client ID') }}"
                                        value="<?= $is_serialized !== false ? isset($is_serialized['client_id']) ?  $is_serialized['client_id'] : '' : ''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <h5 class="mb-0">{{ __('Client Secret') }}</h5>
                            <small>{{ __('Facebook Client Secret') }}</small>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control" name="client_secret" placeholder="{{ __('Client Secret') }}"
                                        value="<?= $is_serialized !== false ? isset($is_serialized['client_secret']) ? $is_serialized['client_secret'] : '' : ''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }?>

                    <?php if($api->name == 'Open AI') {?>
                    <div class="row">
                        <div class="col-md-4">
                            <h5 class="mb-0">{{ __('API Key') }}</h5>
                            <small>{{ __('OpenAI API key') }}</small>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="password" class="form-control" name="api_key" placeholder="{{ __('API Key') }}"
                                        value="<?= $is_serialized !== false ? isset($is_serialized['api_key']) && env('APP_MODE') == '' ? $is_serialized['api_key'] : '' : ''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <h5 class="mb-0">{{ __('Language Model') }}</h5>
                            <small>{{ __('Preferred model') }}</small>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <select class="form-control" name="model">
                                        <option value="">{{ __('Select Here') }}</option>
                                        <option value="text-davinci-003" <?= $is_serialized !== false ? isset($is_serialized['model']) ? $is_serialized['model'] == 'text-davinci-003' ? 'selected' : '' : '' : ''?>>{{ __('text-davinci-003') }}</option>
                                        <option value="gpt-3.5-turbo" <?= $is_serialized !== false ? isset($is_serialized['model']) ? $is_serialized['model'] == 'gpt-3.5-turbo' ? 'selected' : '' : '' : ''?>>{{ __('gpt-3.5-turbo') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Save changes') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
