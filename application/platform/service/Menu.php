<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 2019/1/28
 * Time: 17:11
 */
namespace app\platform\service;

use think\Session;

class Menu
{

    public static $route = [
        'platform/user/me',
        'platform/app/index',
        'platform/app/edit',
        'platform/app/recycle',
        'platform/cache/index',
    ];

    public static function getMenus()
    {
        $menu = self::getMenu();
        $menuList = self::resetList($menu, self::$route);
        $menuList = self::delete($menuList);
        return $menuList;
    }

    private static function getUid()
    {
        return Auth::instance()->getUser()->id;
    }

    public static function resetList($list, $route)
    {
        foreach ($list as $k => $item) {
            if (self::getUid() == 1) {
                $list[$k]['show'] = true;
            } else {
                if (in_array($item['route'], $route)) {
                    $list[$k]['show'] = true;
                } else {
                    $list[$k]['show'] = false;
                }
            }
            if (isset($item['children']) && is_array($item['children'])) {
                $list[$k]['children'] = self::resetList($item['children'], $route);
                foreach ($list[$k]['children'] as $i) {
                    if ($i['show']) {
                        $list[$k]['route'] = $i['route'];
                        $list[$k]['show'] = true;
                        break;
                    }
                }
            }
        }

        return $list;
    }


    public static function delete($menuList)
    {
        foreach ($menuList as $k1 => $item) {
            if (isset($item['children'])) {
                $menuList[$k1]['children'] = self::delete($item['children']);
            }

            if ($item['show'] == false) {
                unset($menuList[$k1]);
            }
        }

        return $menuList;
    }


    public static function getMenu()
    {
        return [
            [
                'name' => '????????????',
                'route' => '',
                'icon' => 'icon-setup',
                'children' => [
                    [
                        'name' => '????????????',
                        'route' => 'platform/user/me',
                        'icon' => 'icon-person',
                        'is_admin' => false,
                    ],
                    [
                        'name' => '????????????',
                        'route' => 'platform/user/index',
                        'icon' => 'icon-liebiao',
                        'is_admin' => true,
                    ],
                    [
                        'name' => '???????????????',
                        'route' => 'platform/user/edit',
                        'icon' => 'icon-add1',
                        'is_admin' => true,
                    ],
                ]
            ],
            [
                'name' => '????????????',
                'route' => '',
                'icon' => 'icon-setup',
                'children' => [
                    [
                        'name' => '????????????',
                        'route' => 'platform/app/index',
                        'icon' => 'icon-shanghu',
                        'is_admin' => false,
                        'sub' => [
                            [
                                'name' => '????????????',
                                'route' => 'platform/app/edit',
                                'is_admin' => false,
                            ],
                            [
                                'name' => '????????????',
                                'route' => 'platform/app/entry',
                                'is_admin' => false,
                            ],
                            [
                                'name' => '????????????',
                                'route' => 'platform/app/delete',
                                'is_admin' => false,
                            ],
                            [
                                'name' => '???????????????',
                                'route' => 'platform/app/recycle',
                                'is_admin' => false,
                            ],
                            [
                                'name' => '???????????????',
                                'route' => 'platform/app/setrecycle',
                                'is_admin' => false,
                            ],
                            [
                                'name' => '????????????',
                                'route' => 'platform/app/disabled',
                                'is_admin' => false,
                            ],
                        ]
                    ],
                    [
                        'name' => '?????????',
                        'route' => 'platform/app/recycle',
                        'icon' => 'icon-huishouzhan',
                        'is_admin' => false,
                    ],
                    [
                        'name' => '???????????????',
                        'route' => 'platform/app/subapp',
                        'icon' => 'icon-xiaochengxu4',
                        'is_admin' => true,
                    ],
                ]
            ],
            [
                'name' => '??????',
                'route' => '',
                'icon' => 'icon-setup',
                'children' => [
                    [
                        'name' => '????????????',
                        'route' => 'platform/setting/index',
                        'icon' => 'icon-settings',
                        'is_admin' => true,
                    ],
                    [
                        'name' => '??????',
                        'route' => 'platform/update/index',
                        'icon' => 'icon-settings',
                        'is_admin' => true,
                    ],
                    [
                        'name' => '????????????',
                        'route' => 'platform/cache/index',
                        'icon' => 'icon-qinglihuancun',
                        'is_admin' => false,
                    ],
                ]
            ],
        ];
    }
}