<?php

namespace AppBundle;

/**
 * Description of AppBundleEvents
 *
 * @author Hubsine <contact@hubsine.com>
 */
final class AppBundleEvents 
{
    /**
     * Cet évènement est lancé lorsqu'un ou plusieurs fichiers sont uploadés via un formulaire 
     * A ce statde aucune entity n'est encore persité.
     * 
     * @Event("AppBundle\Event\UploadMediaEvent")
     */
    const UPLOAD_MEDIA_INITIALIZE               = 'app.upload_media.initialize';
    
    /**
     * Cet évènement est lancé lorsqu'un ou plusieurs fichiers sont uploadés via un formulaire.
     * A ce stade le le media uploadé est persité et flushé en base de données.
     * 
     * @Event("AppBundle\Event\UploadMediaEvent")
     */
    const UPLOAD_MEDIA_COMPLETED                = 'app.upload_media.completed';
    
    /**
     * Cet évènement est lancé avant l'action handleRequest du formulaire afin de conserver les originaux d'un ArrayCollection 
     * pour une futur suppression (formulaire valide).
     * 
     * @Event("AppBundle\Event\FormCollectionEvent")
     */
    const FORM_COLLECTION_INITIALIZE            = 'app.form.collection.initialize';
    
    /**
     * Cet évènement est lancé après l'action handleRequest du formulaire. Il s'agit alors de comparer les élèments du ArrayCollection
     * original d'avec les nouveaux élèments et de supprimer en conséquences les élèments supprimés dans la vue.
     * 
     * @Event("AppBundle\Event\FormCollectionEvent")
     */
    const FORM_COLLECTION_SUCCESS               = 'app.form.collection.success';
}
