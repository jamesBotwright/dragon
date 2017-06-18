<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractActionController
{
    /**
     * @var object $applicationModel
     */
    private $applicationModel;
    
    /**
     * @var object $calendarModel
     */
    private $calendarModel;
    
    /**
     * 
     */
    public function __construct(
        $applicationModel, 
        $calendarModel
    ) {
        $this->applicationModel = $applicationModel;
        $this->calendarModel    = $calendarModel;
    }
    
    /**
     * 
     * @return ViewModel
     */
    public function indexAction()
    {
        return new ViewModel();
    }
    
    /**
     * 
     */
    public function calendarAction()
    {
        return [];
    }
    
    /**
     * 
     */
    public function addEventAction()
    {
        $calendarModel   = $this->calendarModel;
        $request    = $this->getRequest();
        if($request->IsPost()) {
            
        }
        return new JsonModel();
    }
}
