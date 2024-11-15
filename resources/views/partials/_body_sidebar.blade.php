@php
$url = '';

$MyNavBar = \Menu::make('MenuList', function ($menu) use($url){

$menu->add('<span>'.__('messages.main').'</span>', ['class' => 'category-main']);

$menu->add('<span>'.__('messages.dashboard').'</span><span class="custom-tooltip"><span class="tooltip-text">'.__('messages.dashboard').'</span></span>', ['route' => 'home'])
->prepend('<svg width="15" height="15" class="sidebar-menu-icon" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M12.25 1.75V3.25H9.25V1.75H12.25ZM4.75 1.75V6.25H1.75V1.75H4.75ZM12.25 7.75V12.25H9.25V7.75H12.25ZM4.75 10.75V12.25H1.75V10.75H4.75ZM13.75 0.25H7.75V4.75H13.75V0.25ZM6.25 0.25H0.25V7.75H6.25V0.25ZM13.75 6.25H7.75V13.75H13.75V6.25ZM6.25 9.25H0.25V13.75H6.25V9.25Z" fill="#6C757D" />
</svg>')
->link->attr(['class' => '']);


$menu->add(__('messages.sidebar_form_title',['form' => trans('messages.user')]), ['class' => 'category-main'])->data('permission', ['provider list','user list','providerdocument add']);


$menu->add('<span>Students</span><span class="custom-tooltip"><span class="tooltip-text">Students</span></span>', ['class' => ''])
->prepend('<svg width="15" height="15" class="sidebar-menu-icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M6 1.425C6.87 1.425 7.575 2.13 7.575 3C7.575 3.87 6.87 4.575 6 4.575C5.13 4.575 4.425 3.87 4.425 3C4.425 2.13 5.13 1.425 6 1.425ZM6 8.175C8.2275 8.175 10.575 9.27 10.575 9.75V10.575H1.425V9.75C1.425 9.27 3.7725 8.175 6 8.175ZM6 0C4.3425 0 3 1.3425 3 3C3 4.6575 4.3425 6 6 6C7.6575 6 9 4.6575 9 3C9 1.3425 7.6575 0 6 0ZM6 6.75C3.9975 6.75 0 7.755 0 9.75V12H12V9.75C12 7.755 8.0025 6.75 6 6.75Z" fill="#6C757D" />
</svg>')
->nickname('provider')
->data('permission', ['user list','providerdocument add'])
->link->attr(["class" => ""])
->href('#providers');

$menu->provider->add('<span>'.__('messages.list_form_title',['form' => 'Student']).'</span>', ['class' => 'sidebar-layout' ,'route' => ['user.all','all']])
->data('permission', 'user list')
->prepend('<svg width="15" height="15" class="sidebar-menu-icon" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M2 4.875C1.3775 4.875 0.875 5.3775 0.875 6C0.875 6.6225 1.3775 7.125 2 7.125C2.6225 7.125 3.125 6.6225 3.125 6C3.125 5.3775 2.6225 4.875 2 4.875ZM2 0.375C1.3775 0.375 0.875 0.8775 0.875 1.5C0.875 2.1225 1.3775 2.625 2 2.625C2.6225 2.625 3.125 2.1225 3.125 1.5C3.125 0.8775 2.6225 0.375 2 0.375ZM2 9.375C1.3775 9.375 0.875 9.885 0.875 10.5C0.875 11.115 1.385 11.625 2 11.625C2.615 11.625 3.125 11.115 3.125 10.5C3.125 9.885 2.6225 9.375 2 9.375ZM4.25 11.25H14.75V9.75H4.25V11.25ZM4.25 6.75H14.75V5.25H4.25V6.75ZM4.25 0.75V2.25H14.75V0.75H4.25Z" fill="#6C757D" />
</svg>')
->link->attr(['class' => '']);

$menu->provider->add('<span>'.__('messages.list_form_title',['form' => 'Student Document']).'</span>', ['class' => 'sidebar-layout' ,'route' => 'providerdocument.index'])
->data('permission', 'providerdocument list')
->prepend('<svg width="15" height="15" class="sidebar-menu-icon" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M3.25 11.25H8.5V12.75H3.25V11.25ZM3.25 8.25H10.75V9.75H3.25V8.25ZM3.25 5.25H10.75V6.75H3.25V5.25ZM12.25 2.25H9.115C8.8 1.38 7.975 0.75 7 0.75C6.025 0.75 5.2 1.38 4.885 2.25H1.75C1.645 2.25 1.5475 2.2575 1.45 2.28C1.1575 2.34 0.895 2.49 0.6925 2.6925C0.5575 2.8275 0.445 2.9925 0.37 3.1725C0.295 3.345 0.25 3.54 0.25 3.75V14.25C0.25 14.4525 0.295 14.655 0.37 14.835C0.445 15.015 0.5575 15.1725 0.6925 15.315C0.895 15.5175 1.1575 15.6675 1.45 15.7275C1.5475 15.7425 1.645 15.75 1.75 15.75H12.25C13.075 15.75 13.75 15.075 13.75 14.25V3.75C13.75 2.925 13.075 2.25 12.25 2.25ZM7 2.0625C7.3075 2.0625 7.5625 2.3175 7.5625 2.625C7.5625 2.9325 7.3075 3.1875 7 3.1875C6.6925 3.1875 6.4375 2.9325 6.4375 2.625C6.4375 2.3175 6.6925 2.0625 7 2.0625ZM12.25 14.25H1.75V3.75H12.25V14.25Z" fill="#6C757D" />
</svg>')
->link->attr(['class' => '']);

$menu->provider->add('<span>'.__('messages.list_form_title',['form' => 'Upload Student Document']).'</span>', ['class' => 'sidebar-layout' ,'route' => 'providerdocument.create'])
->data('permission', 'providerdocument add')
->prepend('<svg width="15" height="15" class="sidebar-menu-icon" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M3.25 11.25H8.5V12.75H3.25V11.25ZM3.25 8.25H10.75V9.75H3.25V8.25ZM3.25 5.25H10.75V6.75H3.25V5.25ZM12.25 2.25H9.115C8.8 1.38 7.975 0.75 7 0.75C6.025 0.75 5.2 1.38 4.885 2.25H1.75C1.645 2.25 1.5475 2.2575 1.45 2.28C1.1575 2.34 0.895 2.49 0.6925 2.6925C0.5575 2.8275 0.445 2.9925 0.37 3.1725C0.295 3.345 0.25 3.54 0.25 3.75V14.25C0.25 14.4525 0.295 14.655 0.37 14.835C0.445 15.015 0.5575 15.1725 0.6925 15.315C0.895 15.5175 1.1575 15.6675 1.45 15.7275C1.5475 15.7425 1.645 15.75 1.75 15.75H12.25C13.075 15.75 13.75 15.075 13.75 14.25V3.75C13.75 2.925 13.075 2.25 12.25 2.25ZM7 2.0625C7.3075 2.0625 7.5625 2.3175 7.5625 2.625C7.5625 2.9325 7.3075 3.1875 7 3.1875C6.6925 3.1875 6.4375 2.9325 6.4375 2.625C6.4375 2.3175 6.6925 2.0625 7 2.0625ZM12.25 14.25H1.75V3.75H12.25V14.25Z" fill="#6C757D" />
</svg>')
->link->attr(['class' => '']);

$menu->add('<span>'.__('messages.list_form_title',['form' => trans('messages.all_user')]).'</span><span class="custom-tooltip"><span class="tooltip-text">'.__('messages.users').'</span></span>', ['route' => ['staff.all','all']])
->prepend('<svg width="15" height="15" class="sidebar-menu-icon" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M5.75 7.3125C3.995 7.3125 0.5 8.19 0.5 9.9375V11.25H11V9.9375C11 8.19 7.505 7.3125 5.75 7.3125ZM2.255 9.75C2.885 9.315 4.4075 8.8125 5.75 8.8125C7.0925 8.8125 8.615 9.315 9.245 9.75H2.255ZM5.75 6C7.1975 6 8.375 4.8225 8.375 3.375C8.375 1.9275 7.1975 0.75 5.75 0.75C4.3025 0.75 3.125 1.9275 3.125 3.375C3.125 4.8225 4.3025 6 5.75 6ZM5.75 2.25C6.3725 2.25 6.875 2.7525 6.875 3.375C6.875 3.9975 6.3725 4.5 5.75 4.5C5.1275 4.5 4.625 3.9975 4.625 3.375C4.625 2.7525 5.1275 2.25 5.75 2.25ZM11.03 7.3575C11.9 7.9875 12.5 8.8275 12.5 9.9375V11.25H15.5V9.9375C15.5 8.4225 12.875 7.56 11.03 7.3575ZM10.25 6C11.6975 6 12.875 4.8225 12.875 3.375C12.875 1.9275 11.6975 0.75 10.25 0.75C9.845 0.75 9.47 0.8475 9.125 1.0125C9.5975 1.68 9.875 2.4975 9.875 3.375C9.875 4.2525 9.5975 5.07 9.125 5.7375C9.47 5.9025 9.845 6 10.25 6Z" fill="#6C757D" />
</svg>')
->nickname('staff')
->data('permission', 'staff list');

$menu->add('<span>'.__('messages.document').'</span><span class="custom-tooltip"><span class="tooltip-text">'.__('messages.document').'</span></span>', ['class' => ''])
->prepend('<svg width="15" height="15" class="sidebar-menu-icon" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M14.25 3.75V14.25H3.75V3.75H14.25ZM14.25 2.25H3.75C2.925 2.25 2.25 2.925 2.25 3.75V14.25C2.25 15.075 2.925 15.75 3.75 15.75H14.25C15.075 15.75 15.75 15.075 15.75 14.25V3.75C15.75 2.925 15.075 2.25 14.25 2.25Z" fill="#6C757D" />
    <path d="M10.5 12.75H5.25V11.25H10.5V12.75ZM12.75 9.75H5.25V8.25H12.75V9.75ZM12.75 6.75H5.25V5.25H12.75V6.75Z" fill="#6C757D" />
</svg>')
->nickname('document')
->data('permission', 'document list')
->link->attr(["class" => ""])
->href('#document');

$menu->document->add('<span>'.__('messages.list_form_title',['form' => trans('messages.document') ]).'</span>', [ 'class' => 'sidebar-layout' , 'route' => ['document.index']])
->prepend('<svg width="15" height="15" class="sidebar-menu-icon" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M2 4.875C1.3775 4.875 0.875 5.3775 0.875 6C0.875 6.6225 1.3775 7.125 2 7.125C2.6225 7.125 3.125 6.6225 3.125 6C3.125 5.3775 2.6225 4.875 2 4.875ZM2 0.375C1.3775 0.375 0.875 0.8775 0.875 1.5C0.875 2.1225 1.3775 2.625 2 2.625C2.6225 2.625 3.125 2.1225 3.125 1.5C3.125 0.8775 2.6225 0.375 2 0.375ZM2 9.375C1.3775 9.375 0.875 9.885 0.875 10.5C0.875 11.115 1.385 11.625 2 11.625C2.615 11.625 3.125 11.115 3.125 10.5C3.125 9.885 2.6225 9.375 2 9.375ZM4.25 11.25H14.75V9.75H4.25V11.25ZM4.25 6.75H14.75V5.25H4.25V6.75ZM4.25 0.75V2.25H14.75V0.75H4.25Z" fill="#6C757D" />
</svg>')
->data('permission', 'document list')
->link->attr(array('class' => ''));

$menu->document->add('<span>'.__('messages.add_form_title',['form' => trans('messages.document')]).'</span>', array( 'class' => 'sidebar-layout', 'route' => 'document.create'))
->prepend('<svg width="15" height="15" class="sidebar-menu-icon" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M8.75 4.25H7.25V7.25H4.25V8.75H7.25V11.75H8.75V8.75H11.75V7.25H8.75V4.25ZM8 0.5C3.86 0.5 0.5 3.86 0.5 8C0.5 12.14 3.86 15.5 8 15.5C12.14 15.5 15.5 12.14 15.5 8C15.5 3.86 12.14 0.5 8 0.5ZM8 14C4.6925 14 2 11.3075 2 8C2 4.6925 4.6925 2 8 2C11.3075 2 14 4.6925 14 8C14 11.3075 11.3075 14 8 14Z" fill="#6C757D" />
</svg>')
->data('permission', 'document add')
->link->attr(['class' => '']);

$menu->add(__('messages.sidebar_form_title',['form' => 'Settings']), ['class' => 'category-main'])->data('permission', ['role list','permission list']);
$menu->add('<span>'.__('messages.account_setting').'</span><span class="custom-tooltip"><span class="tooltip-text">'.__('messages.account_setting').'</span></span>', ['class' => ''])
->prepend('<svg width="15" height="15" class="sidebar-menu-icon" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M8 0.5C3.86 0.5 0.5 3.86 0.5 8C0.5 12.14 3.86 15.5 8 15.5C12.14 15.5 15.5 12.14 15.5 8C15.5 3.86 12.14 0.5 8 0.5ZM4.5125 12.875C5.495 12.17 6.695 11.75 8 11.75C9.305 11.75 10.505 12.17 11.4875 12.875C10.505 13.58 9.305 14 8 14C6.695 14 5.495 13.58 4.5125 12.875ZM12.605 11.84C11.3375 10.85 9.74 10.25 8 10.25C6.26 10.25 4.6625 10.85 3.395 11.84C2.525 10.7975 2 9.4625 2 8C2 4.685 4.685 2 8 2C11.315 2 14 4.685 14 8C14 9.4625 13.475 10.7975 12.605 11.84Z" fill="#6C757D" />
    <path d="M8 3.5C6.5525 3.5 5.375 4.6775 5.375 6.125C5.375 7.5725 6.5525 8.75 8 8.75C9.4475 8.75 10.625 7.5725 10.625 6.125C10.625 4.6775 9.4475 3.5 8 3.5ZM8 7.25C7.3775 7.25 6.875 6.7475 6.875 6.125C6.875 5.5025 7.3775 5 8 5C8.6225 5 9.125 5.5025 9.125 6.125C9.125 6.7475 8.6225 7.25 8 7.25Z" fill="#6C757D" />
</svg>')
->nickname('account_setting')
->data('permission', ['role list','permission list'])
->link->attr(["class" => ""])
->href('#account_setting');

$menu->account_setting->add('<span>'.__('messages.list_form_title',['form' => __('messages.role')]).'</span>', ['class' => 'sidebar-layout' ,'route' => 'role.index'])
->data('permission', 'role list')
->prepend('<svg width="15" height="15" class="sidebar-menu-icon" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M2 4.875C1.3775 4.875 0.875 5.3775 0.875 6C0.875 6.6225 1.3775 7.125 2 7.125C2.6225 7.125 3.125 6.6225 3.125 6C3.125 5.3775 2.6225 4.875 2 4.875ZM2 0.375C1.3775 0.375 0.875 0.8775 0.875 1.5C0.875 2.1225 1.3775 2.625 2 2.625C2.6225 2.625 3.125 2.1225 3.125 1.5C3.125 0.8775 2.6225 0.375 2 0.375ZM2 9.375C1.3775 9.375 0.875 9.885 0.875 10.5C0.875 11.115 1.385 11.625 2 11.625C2.615 11.625 3.125 11.115 3.125 10.5C3.125 9.885 2.6225 9.375 2 9.375ZM4.25 11.25H14.75V9.75H4.25V11.25ZM4.25 6.75H14.75V5.25H4.25V6.75ZM4.25 0.75V2.25H14.75V0.75H4.25Z" fill="#6C757D" />
</svg>')
->link->attr(['class' => '']);

$menu->account_setting->add('<span>'.__('messages.list_form_title',['form' => __('messages.permission')]).'</span>', ['class' => 'sidebar-layout' ,'route' => 'permission.index'])
->data('permission', 'permission list')
->prepend('<svg width="15" height="15" class="sidebar-menu-icon" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M2 4.875C1.3775 4.875 0.875 5.3775 0.875 6C0.875 6.6225 1.3775 7.125 2 7.125C2.6225 7.125 3.125 6.6225 3.125 6C3.125 5.3775 2.6225 4.875 2 4.875ZM2 0.375C1.3775 0.375 0.875 0.8775 0.875 1.5C0.875 2.1225 1.3775 2.625 2 2.625C2.6225 2.625 3.125 2.1225 3.125 1.5C3.125 0.8775 2.6225 0.375 2 0.375ZM2 9.375C1.3775 9.375 0.875 9.885 0.875 10.5C0.875 11.115 1.385 11.625 2 11.625C2.615 11.625 3.125 11.115 3.125 10.5C3.125 9.885 2.6225 9.375 2 9.375ZM4.25 11.25H14.75V9.75H4.25V11.25ZM4.25 6.75H14.75V5.25H4.25V6.75ZM4.25 0.75V2.25H14.75V0.75H4.25Z" fill="#6C757D" />
</svg>')
->link->attr(['class' => '']);


$menu->add('<span>'.__('messages.setting').'</span><span class="custom-tooltip"><span class="tooltip-text">'.__('messages.setting').'</span></span>', ['route' => 'setting.index'])
->prepend('<svg width="15" height="15" class="sidebar-menu-icon" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M13.5725 8.735C13.6025 8.495 13.625 8.255 13.625 8C13.625 7.745 13.6025 7.505 13.5725 7.265L15.155 6.0275C15.2975 5.915 15.335 5.7125 15.245 5.5475L13.745 2.9525C13.6775 2.8325 13.55 2.765 13.415 2.765C13.37 2.765 13.325 2.7725 13.2875 2.7875L11.42 3.5375C11.03 3.2375 10.61 2.99 10.1525 2.8025L9.8675 0.815C9.845 0.635 9.6875 0.5 9.5 0.5H6.5C6.3125 0.5 6.155 0.635 6.1325 0.815L5.8475 2.8025C5.39 2.99 4.97 3.245 4.58 3.5375L2.7125 2.7875C2.6675 2.7725 2.6225 2.765 2.5775 2.765C2.45 2.765 2.3225 2.8325 2.255 2.9525L0.755002 5.5475C0.657502 5.7125 0.702502 5.915 0.845002 6.0275L2.4275 7.265C2.3975 7.505 2.375 7.7525 2.375 8C2.375 8.2475 2.3975 8.495 2.4275 8.735L0.845002 9.9725C0.702502 10.085 0.665002 10.2875 0.755002 10.4525L2.255 13.0475C2.3225 13.1675 2.45 13.235 2.585 13.235C2.63 13.235 2.675 13.2275 2.7125 13.2125L4.58 12.4625C4.97 12.7625 5.39 13.01 5.8475 13.1975L6.1325 15.185C6.155 15.365 6.3125 15.5 6.5 15.5H9.5C9.6875 15.5 9.845 15.365 9.8675 15.185L10.1525 13.1975C10.61 13.01 11.03 12.755 11.42 12.4625L13.2875 13.2125C13.3325 13.2275 13.3775 13.235 13.4225 13.235C13.55 13.235 13.6775 13.1675 13.745 13.0475L15.245 10.4525C15.335 10.2875 15.2975 10.085 15.155 9.9725L13.5725 8.735ZM12.0875 7.4525C12.1175 7.685 12.125 7.8425 12.125 8C12.125 8.1575 12.11 8.3225 12.0875 8.5475L11.9825 9.395L12.65 9.92L13.46 10.55L12.935 11.4575L11.9825 11.075L11.2025 10.76L10.5275 11.27C10.205 11.51 9.8975 11.69 9.59 11.8175L8.795 12.14L8.675 12.9875L8.525 14H7.475L7.3325 12.9875L7.2125 12.14L6.4175 11.8175C6.095 11.6825 5.795 11.51 5.495 11.285L4.8125 10.76L4.0175 11.0825L3.065 11.465L2.54 10.5575L3.35 9.9275L4.0175 9.4025L3.9125 8.555C3.89 8.3225 3.875 8.15 3.875 8C3.875 7.85 3.89 7.6775 3.9125 7.4525L4.0175 6.605L3.35 6.08L2.54 5.45L3.065 4.5425L4.0175 4.925L4.7975 5.24L5.4725 4.73C5.795 4.49 6.1025 4.31 6.41 4.1825L7.205 3.86L7.325 3.0125L7.475 2H8.5175L8.66 3.0125L8.78 3.86L9.575 4.1825C9.8975 4.3175 10.1975 4.49 10.4975 4.715L11.18 5.24L11.975 4.9175L12.9275 4.535L13.4525 5.4425L12.65 6.08L11.9825 6.605L12.0875 7.4525ZM8 5C6.3425 5 5 6.3425 5 8C5 9.6575 6.3425 11 8 11C9.6575 11 11 9.6575 11 8C11 6.3425 9.6575 5 8 5ZM8 9.5C7.175 9.5 6.5 8.825 6.5 8C6.5 7.175 7.175 6.5 8 6.5C8.825 6.5 9.5 7.175 9.5 8C9.5 8.825 8.825 9.5 8 9.5Z" fill="#6C757D" />
</svg>')
->nickname('setting')
->data('permission', ['system setting','sys settings']);



})->filter(function ($item) {
return checkMenuRoleAndPermission($item);
});

@endphp
<div class="iq-sidebar sidebar-default">
    <div class="iq-sidebar-logo">
        <a href="{{ route('home') }}" class="header-logo">
            <img src="{{ getSingleMedia(settingSession('get'),'site_logo',null) }}" class="img-fluid rounded-normal light-logo site_logo_preview" alt="logo">
            <img src="{{ getSingleMedia(settingSession('get'),'site_logo',null) }}" class="img-fluid rounded-normal darkmode-logo site_logo_preview" alt="logo">
            <span class="white-space-no-wrap">{{ ucfirst(str_replace("_"," ",auth()->user()->user_type)) }}</span>
        </a>
        <div class="side-menu-bt-sidebar-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="text-light wrapper-menu" width="30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>
    </div>
    <div class="side-menu-bt-sidebar wide-device-toggle">
        <span class="iq-toggle-arrow">
            <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon arrow-active wrapper-menu" height="14" width="15" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </span>
    </div>
    <div class="data-scrollbar" data-scroll="1">
        <div class="user-profile">
            <div class="avatar">
            <img class="avatar-50 rounded-circle bg-light" alt="user-icon" src="{{ getSingleMedia(auth()->user(),'profile_image', null) }}">
            </div>
            <div class="user-info">
                <h5 class="user-email">{{auth()->user()->email}}</h5>
                <span class="user-name">{{auth()->user()->display_name}}</span>
            </div>
        </div>
        <nav class="iq-sidebar-menu">
            <ul id="iq-sidebar-toggle" class="side-menu">
                @include(config('laravel-menu.views.bootstrap-items'), ['items' => $MyNavBar->roots()])
            </ul>
        </nav>
        <div class="pt-5 pb-5"></div>
    </div>
</div>