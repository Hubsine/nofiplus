<?php

namespace AppBundle;

/**
 * Description of AppBundleAdminEvents
 *
 * @author Hubsine <contact@hubsine.com>
 */
final class AppBundleAdminEvents 
{
    const ADMIN_ENTITY_NEW_INITIALIZE           = 'admin.entity.new.initialize';
    const ADMIN_ENTITY_NEW_SUCCESS              = 'admin.entity.new.success';
    const ADMIN_ENTITY_NEW_COMPLETED            = 'admin.entity.new.completed';
    const ADMIN_ENTITY_NEW_FAILURE              = 'admin.entity.new.failure';
    
    const ADMIN_ENTITY_UPDATE_INITIALIZE        = 'admin.entity.update.initialize';
    const ADMIN_ENTITY_UPDATE_SUCCESS           = 'admin.entity.update.success';
    const ADMIN_ENTITY_UPDATE_COMPLETED         = 'admin.entity.update.completed';
    const ADMIN_ENTITY_UPDATE_FAILURE           = 'admin.entity.update.failure';
    
    const ADMIN_ENTITY_DELETE_INITIALIZE        = 'admin.entity.delete.initialize';
    const ADMIN_ENTITY_DELETE_SUCCESS           = 'admin.entity.delete.success';
    const ADMIN_ENTITY_DELETE_COMPLETED         = 'admin.entity.delete.completed';
    const ADMIN_ENTITY_DELETE_FAILURE           = 'admin.entity.delete.failure';
}
