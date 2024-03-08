<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use DB;
use File;
use Session;
use Menu;

class UtilityModel extends BaseModel {

    public function __construct() {
        parent:: __construct();
    }

    public static function uploadFile($file, $upload_dir, $new_file_name = '') {
        if ($file->isValid()) {
            $ext = $file->getClientOriginalExtension();
            if ($new_file_name == '') {
                $new_file_name = $file->getClientOriginalName();
            }

            $fullfileName = $new_file_name;
            $hasDir = self::hasOrCreateDir($upload_dir);
            if (!$hasDir)
                return false;

            if (file_exists($upload_dir . '/' . $fullfileName)) {
                File::delete($upload_dir . '/' . $fullfileName);
            }
            $file->move($upload_dir, $fullfileName);
            //echo 1;exit;
            return true;
        } else {
            //echo 2;exit;
            return false;
        }
    }

    /**

     * accept parameter: $dir = Directory name
     * return true on success else return false
     * purpose: Check if directory exists .If not exists then create directory
     */
    public static function hasOrCreateDir($dir) {

        if (!file_exists($dir)) {
            return mkdir($dir, 0755, true);
        } else {
            return true;
        }
    }

    public static function getMessage($msg, $type = 'success') {
        if ($type == 'success') {
            return $modified_msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>' . $msg . '</strong></div>';
        } else {
            return $modified_msg = '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>' . $msg . '</strong></div>';
        }
    }

    public static function isDateBetweenDates(\DateTime $date, \DateTime $startDate, \DateTime $endDate) {
        return $date >= $startDate && $date <= $endDate;
    }

    public static function checkDateRange($dateArray, \DateTime $start_date, \DateTime $end_date) {

        foreach ($dateArray as $dateStr) {
            // $curDate = strtotime($dateStr);
            if ($dateStr < ($start_date) || $dateStr > ($end_date)) {
                return false;
                // echo "Dates are NOT within range";
            }
        }
        // echo "Dates are within range";exit;
        return true;
    }

    public function makeMenu($current_user) {

        // t($current_user, 1);
        $this->current_user_type = $current_user['user_type'];
        $this->current_user_id = $current_user['id'];
        $this->current_user_role_id = $role_id = $current_user['role_id'];
        $this->current_user_role_name = ($role_id) ? Role\Role::where(['id' => $role_id])->value('name') : '';
        Menu::make('MyNavBar', function($menu) {

            //dashborad
            $menu->group(array('prefix' => 'dashboard'), function($search) {
                $search->add('<span class="txt">Dashboard</span>', array('url' => '', 'secure' => false))->data('permission', array('dashboard_access'));
            });
			$menu->group(array('prefix' => 'map'), function($search) {
                $search->add('<span class="txt">Map</span>', array('url' => 'view', 'secure' => false))->data('permission', array('map_access'));
            });
            //  ->data('permission', array('lis','view'))
            //search
            $menu->group(array(), function($search_menu) {
                $search = $search_menu->add('Search', array('url' => '#', 'secure' => false))->nickname('search')->data('permission', array());

                // ->data('permission', array('edit','coustome'));
                $search->link->attr(array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'role' => 'button', ' aria-expanded' => 'false'));
                if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("registration_access", $this->current_user_id)) {
                    $search_menu->group(array('prefix' => 'land-details-entry'), function($master) {
                        $master->search->add('Land Record', array('url' => 'registration/list', 'secure' => false))->data('permission', array('registration_search'));
                    });
                }
                if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("patta_access", $this->current_user_id)) {
                    $search_menu->group(array('prefix' => 'land-details-entry'), function($master) {
                        $master->search->add('Patta Record', array('url' => 'patta/list', 'secure' => false))->data('permission', array('patta_search'));
                    });
                }
                $search_menu->search->attr('class', 'dropdown');
            });

            //entry
            $menu->group(array(), function($entry_menu) {
                $entry = $entry_menu->add('Entry', array('url' => '#', 'secure' => false))->nickname('entry')->data('permission', array());
                $entry->link->attr(array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'role' => 'button', ' aria-expanded' => 'false'));
                if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("registration_access", $this->current_user_id)) {
                    $entry_menu->group(array('prefix' => 'land-details-entry'), function($master) {
                        $master->entry->add('Land Record', array('url' => 'registration/add', 'secure' => false))->data('permission', array('registration_add'));
                    });
                }
                if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("patta_access", $this->current_user_id)) {
                    $entry_menu->group(array('prefix' => 'land-details-entry'), function($master) {
                        $master->entry->add('Patta Record', array('url' => 'patta/add', 'secure' => false))->data('permission', array('patta_add'));
                    });
                }
                $entry_menu->entry->attr('class', 'dropdown');
            });

            //transaction
            $menu->group(array(), function($trnxn_menu) {
                $trnxn = $trnxn_menu->add('Transaction', array('url' => '#', 'secure' => false))->nickname('trnxn')->data('permission', array());
                $trnxn->link->attr(array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'role' => 'button', ' aria-expanded' => 'false'));
				
				 if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("audit_status_access", $this->current_user_id)) {
                $trnxn_menu->group(array('url' => '#', 'secure' => false), function($master) {
                    $master->trnxn->add('Audit Status', array('url' => 'transaction/audit/add', 'secure' => false))->data('permission', array('audit_status_add'));
                });
				 }
				 
				 if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("conversion_to_parent_company_access", $this->current_user_id)) {
                $trnxn_menu->group(array('url' => '#', 'secure' => false), function($master) {
                    $master->trnxn->add('Conversion to Parent Company', array('url' => 'transaction/conversion-parent-company/add', 'secure' => false))->data('permission', array('conversion_to_parent_company_add'));
                });
				 }
				 
				if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("disputes_access", $this->current_user_id)) {
                $trnxn_menu->group(array('url' => '#', 'secure' => false), function($master) {
                    $master->trnxn->add('Disputes', array('url' => 'transaction/disputes/add', 'secure' => false))->data('permission', array('disputes_add'));
                });
				}
				
				 if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("hypothecation_access", $this->current_user_id)) {
                $trnxn_menu->group(array('url' => '#', 'secure' => false), function($master) {
                    $master->trnxn->add('Hypothecation', array('url' => 'transaction/hypothecation/add', 'secure' => false))->data('permission', array('hypothecation_add'));
                });
				 }
//                $trnxn_menu->group(array('url' => '#', 'secure' => false), function($master) {
//                    $master->trnxn->add('Document Verification', 'javascript:void(0)')->data('permission', array());
//                });
               if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("land_ceiling_access", $this->current_user_id)) {
                $trnxn_menu->group(array('url' => '#', 'secure' => false), function($master) {
                    $master->trnxn->add('Land Ceiling', array('url' => 'transaction/land-ceiling/add', 'secure' => false))->data('permission', array('land_ceiling_add'));
                });
			   }
			   
			    if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("land_conversion_access", $this->current_user_id)) {
                $trnxn_menu->group(array('url' => '#', 'secure' => false), function($master) {
                    $master->trnxn->add('Land Conversion', array('url' => 'transaction/land-conversion/add', 'secure' => false))->data('permission', array('land_conversion_add'));
                });
				}
				
				 if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("land_exchange_access", $this->current_user_id)) {
                $trnxn_menu->group(array('url' => '#', 'secure' => false), function($master) {
                    $master->trnxn->add('Land Exchange', array('url' => 'transaction/land-exchange/add', 'secure' => false))->data('permission', array('land_exchange_add'));
                });
				 }
				 
				  if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("land_inspection_access", $this->current_user_id)) {
                $trnxn_menu->group(array('url' => '#', 'secure' => false), function($master) {
                    $master->trnxn->add('Land Inspection', array('url' => 'transaction/inspection/add', 'secure' => false))->data('permission', array('land_inspection_add'));
                });
				  }
				  
				   if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("land_reservation_access", $this->current_user_id)) {
                $trnxn_menu->group(array('url' => '#', 'secure' => false), function($master) {
                    $master->trnxn->add('Land Reservation', array('url' => 'transaction/land-reservation/add', 'secure' => false))->data('permission', array('land_reservation_add'));
                });
				   }
				   
				    if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("lease_access", $this->current_user_id)) {
                $trnxn_menu->group(array('prefix' => 'lease-management'), function($master) {
                    $master->trnxn->add('Lease', array('url' => 'add', 'secure' => false))->data('permission', array('lease_add'));
                });
					}
					
					 if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("mining_lease_access", $this->current_user_id)) {
                $trnxn_menu->group(array('url' => '#', 'secure' => false), function($master) {
                    $master->trnxn->add('Mining Lease', array('url' => 'transaction/mining-lease/add', 'secure' => false))->data('permission', array('mining_lease_add'));
                });
					 }
					 
					  if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("mutation_access", $this->current_user_id)) {
                $trnxn_menu->group(array('url' => '#', 'secure' => false), function($master) {
                    $master->trnxn->add('Mutation', array('url' => 'transaction/mutation/add', 'secure' => false))->data('permission', array('mutation_add'));
                });
					  }
					  
					   if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("payment_access", $this->current_user_id)) {
                $trnxn_menu->group(array('prefix' => 'payment'), function($master) {
                    $master->trnxn->add('Payment', array('url' => 'add', 'secure' => false))->data('permission', array('payment_add'));
                });
					   }
//                $trnxn_menu->group(array('url' => '#', 'secure' => false), function($master) {
//                    $master->trnxn->add('Land Tax', 'javascript:void(0)');
//                });

 if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("under_operation_access", $this->current_user_id)) {
                $trnxn_menu->group(array('url' => '#', 'secure' => false), function($master) {
                    $master->trnxn->add('Under Operation', array('url' => 'transaction/under-operation/add', 'secure' => false))->data('permission', array('under_operation_add'));
                });
 }
                $trnxn_menu->trnxn->attr('class', 'dropdown');
            });

            //MIS
//            $menu->group(array('url' => '#', 'secure' => false), function($search) {
//                $search->add('MIS', array('url' => 'mis/search', 'secure' => false))->data('permission', array());
//            });

            $menu->group(array(), function($mis_menu) {
                $mis = $mis_menu->add('MIS', array('url' => '#', 'secure' => false))->nickname('mis')->data('permission', array());

                // ->data('permission', array('edit','coustome'));
                $mis->link->attr(array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'role' => 'button', ' aria-expanded' => 'false'));
                // if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("mis_access", $this->current_user_id)) {
               if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("registration_mis_access", $this->current_user_id)) {
                    $mis_menu->group(array('prefix' => 'mis'), function($master) {
                        //  $master->mis->add('Registration Details', array('url' => 'registration', 'secure' => false))->data('permission', array(''));
                        $master->mis->add('Registration Details', array('url' => 'registration', 'secure' => false));
                    });
                }
               if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("transaction_mis", $this->current_user_id)) {
                    $mis_menu->group(array('prefix' => 'mis'), function($master) {
                        // $master->mis->add('Transaction Details', array('url' => '', 'secure' => false))->data('permission', array(''));
                        $master->mis->add('Transaction Details', array('url' => 'transaction', 'secure' => false));
                    });
                }
                $mis_menu->mis->attr('class', 'dropdown');
            });

            //contact
			if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("contacts_access", $this->current_user_id)) {
            $menu->group(array('prefix' => ''), function($search) {
                $search->add('Contacts', array('url' => 'contact', 'secure' => false))->data('permission', array());
            });
			}
            //admin
            $menu->group(array(), function($admin_menu) {
                $admin = $admin_menu->add('Admin', array('url' => '#', 'secure' => false))->nickname('admin')->data('permission', array());
                $admin->link->attr(array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'role' => 'button', ' aria-expanded' => 'false'));

                //if ($this->current_user_type == 'admin') {
					if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("activity_log_access", $this->current_user_id)) {

					 $admin_menu->group(array(''), function($master) {
                        $master->admin->add('Activity Log', array('url' => 'user-management/user/log', 'secure' => false))->data('permission', array());
                    });
					}
					
					if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("audit_log_access", $this->current_user_id)) {
					 $admin_menu->group(array(''), function($master) {
                        $master->admin->add('Audit Log', array('url' => 'master/audit/audit-log', 'secure' => false))->data('permission', array());
                    });
					}
					
                    if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("audit_master_management_access", $this->current_user_id)) {					
					$admin_menu->group(array(''), function($master) {
                        $master->admin->add('Audit Master Management', array('url' => 'user-management/audit/add', 'secure' => false))->data('permission', array());
                    });
					}
					
					if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("form_management_access", $this->current_user_id)) {
					 $admin_menu->group(array(''), function($master) {
                        $master->admin->add('Form Management', array('url' => 'user-management/form/add', 'secure' => false))->data('permission', array());
                    });
					}
					
					if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("master_data_management_access", $this->current_user_id)) {
					$admin_menu->group(array('prefix' => 'master'), function($master) {
						$master->admin->add('Master Data Management', array('url' => 'data/management', 'secure' => false))->data('permission', array());
					});
					}
				
				if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("master_user_access", $this->current_user_id)) {
                    $admin_menu->group(array(''), function($master) {
                        $master->admin->add('Master User', array('url' => 'master-user/add', 'secure' => false))->data('permission', array());
                    });
				}
				
				if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("role_management_access", $this->current_user_id)) {
                    $admin_menu->group(array(''), function($master) {
                        $master->admin->add('Role Management', array('url' => 'user-management/role/add', 'secure' => false))->data('permission', array());
                    });
				}                  
					/*$admin_menu->group(array(''), function($master) {
						$master->admin->add('Shape File Import', array('url' => 'document-management/document/shape-file-list', 'secure' => false))->data('permission', array('shape_file_access'));
					});*/
					
				if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("shape_file_access", $this->current_user_id)) {
				$admin_menu->group(array(''), function($master) {
						$master->admin->add('Shape File Import', array('url' => 'document-management/document/shape-file-list', 'secure' => false))->data('permission', array());
					});
				}
				
				 //if ($this->current_user_type == 'admin') {
					 if ($this->current_user_type == 'admin' || UtilityModel::ifHasPermission("user_log_access", $this->current_user_id)) {
                    $admin_menu->group(array(''), function($master) {
                        $master->admin->add('User Log', array('url' => 'user-management/user/loginlog', 'secure' => false))->data('permission', array());
                    });
					 }
					if ($this->current_user_type == 'admin' || $this->current_user_role_name == 'manager' || $this->current_user_role_name == 'auditor' || $this->current_user_role_name == 'superviser') {
						$admin_menu->group(array('class' => ''), function($master) {
						$master->admin->add('User Management', array('url' => 'user-management/user/add', 'secure' => false))->data('permission', array());
						});
					}
					
					/*$admin_menu->group(array(''), function($master) {
                        $master->admin->add('Approval Management', array('url' => 'approval-management/approval/add', 'secure' => false))->data('permission', array());
                    });
					
					if ($this->current_user_role_id == 4 || $this->current_user_role_id == 8 || $this->current_user_role_id == 9) {
						$admin_menu->group(array('class' => ''), function($master) {
							$master->admin->add('Approval', array('url' => 'approval-management/approval/track', 'secure' => false))->data('permission', array());
						});
					}
					
					$admin_menu->group(array(''), function($master) {
                        $master->admin->add('Document Management', array('url' => 'document-management/document/list', 'secure' => false))->data('permission', array());
                    });*/
					
					
                //}
				
                $admin_menu->admin->attr('class', 'dropdown');
            });

            //logout
            $menu->group(array('prefix' => ''), function($search) {
                $search->add(' <span class="tooltip" style="font-size: 15px !important;opacity: 1 !important;" data-toggle="tooltip" data-original-title="Logout"><span class="fa fa-power-off"></span>
                        <span class="sr-only">Logout</span></span>', array('url' => 'logout', 'secure' => false))->data('permission', array());
            });
            $menu->group(array('prefix' => ''), function($search) {
                $search->add(' <span class="tooltip" style="margin-left: 10px;font-size: 15px !important;opacity: 1 !important;" data-toggle="tooltip" data-original-title="Change Password"><span class="fa fa-key"></span>
                        <span class="sr-only">Change Password</span>', array('url' => 'change-password', 'secure' => false))->data('permission', array());
            });
        })->filter(function($item) {
            //print_r($item->data('permission'))  ;                   
            if ($this->current_user_type == 'admin') {
                return true;
            } else {
                $permissions = ($item->data('permission')) ? $item->data('permission') : '';
                //print_r($permissions);
                $user_obj = new User\UserModel();
                if ($permissions) {
                    foreach ($permissions as $key => $value) {
                        // echo $value;
                        $has_permission = $user_obj->ifHasPermission($value, $this->current_user_id);
                        if ($has_permission) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                }
                return true;
            }
        });
    }

    public static function ifHasPermission($permission_name, $user_id) {
        //  $assigned_permissions = $this->where(['id' => $user_id])->select('permissions')->get()->toArray();
        $assigned_permissions = User\UserModel::where(['id' => $user_id])->select('permissions')->get()->toArray();
        $assigned_permissions = isset($assigned_permissions[0]['permissions']) ? $assigned_permissions[0]['permissions'] : '';
        $assigned_permissions = ($assigned_permissions) ? explode(",", $assigned_permissions) : [];
        if (in_array($permission_name, $assigned_permissions)) {
            return true;
        } else {
            return false;
        }
    }

    public static function randomPassword($length = 8) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr(str_shuffle($chars), 0, $length);
        return $password;
    }

    public static function randomKey($length = 8) {
        //$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!_";
        $password = substr(str_shuffle($chars), 0, $length);
        return $password;
    }

    public static function assignedDistricts($user_type, $assigned_states, $current_user_id) {
        $assgined_districts = [];
        if ($user_type !== 'admin') {
            if ($assigned_states) {
                $assigned_states = explode(",", $assigned_states);
                //t($assigned_states,1);
                foreach ($assigned_states as $key => $value) {
                    $districts = \App\Models\User\AssginedStateDistrictModel::where(['state_id' => $value, 'user_id' => $current_user_id])->select('district_id')->get()->toArray();
                    // t($districts);
                    if ($districts) {
                        foreach ($districts as $dist_key => $dist_value) {
                            $assgined_districts[] = $dist_value['district_id'];
                        }
                    }
                }
                return $assgined_districts_str = ($assgined_districts) ? "'" . implode("','", $assgined_districts) . "'" : '';
                //t($assgined_districts,1);
//                if ($assgined_districts_str) {
//                    $cond.= " AND district_id in ($assgined_districts_str) ";
//                }
            }
        }
    }

}
