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
    public function songsAction()
    {
        $calendarModel   = $this->calendarModel;
        $eventsForm      = $calendarModel->getEventsForm();
        return [
            'eventsForm'   => $eventsForm,
        ];
    }
    
    /**
     * 
     */
    public function calendarAction()
    {
        $calendarModel   = $this->calendarModel;
        $eventsForm      = $calendarModel->getEventsForm();
        return [
            'eventsForm'   => $eventsForm,
        ];
    }
    
    public function getEventsAction()
    {
        $calendarModel  = $this->calendarModel;
        $request        = $this->getRequest();
        $startDate      = $request->getQuery('start');
        $endDate        = $request->getQuery('end');
        $events         = $calendarModel->getEvents($startDate, $endDate);
        return new JsonModel($events);
    }
    
    /**
     * 
     */
    public function addEventAction()
    {
        $calendarModel   = $this->calendarModel;
        $eventsForm      = $calendarModel->getEventsForm();
        $request         = $this->getRequest();
        if($request->IsPost()) {
            $eventsForm->setData($request->getPost());
            $eventsForm->setInputFilter($eventsForm->getInputFilter());
            if($eventsForm->isValid()) {
                $calendarModel->persistFlush();
            } else {
                $this->getResponse()->setStatusCode(401);
            }
        }
        $viewModel = new ViewModel();
        $viewModel->setVariables([
                'eventsForm'   => $eventsForm,
            ])
            ->setTemplate('application/index/partial/add-event-modal.phtml')
            ->setTerminal(true);
        return $viewModel;
    }
}
