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
     * @var object $songsModel
     */
    private $songsModel;
    
    /**
     * 
     */
    public function __construct(
        $applicationModel, 
        $calendarModel,
        $songsModel
    ) {
        $this->applicationModel = $applicationModel;
        $this->calendarModel    = $calendarModel;
        $this->songsModel       = $songsModel;
    }
    
    /**
     * 
     * @return ViewModel
     */
    public function indexAction()
    {
        $calendarModel   = $this->calendarModel;
        $upcomingEvents  = $calendarModel->getUpcomingEvents(3);
        return [
            'upcomingEvents' => $upcomingEvents,
        ];
    }
    
    /**
     * 
     */
    public function songsAction()
    {
        $songsModel         = $this->songsModel;
        $addSongForm        = $songsModel->getAddSongForm();
        $suggestedSongs     = $songsModel->getSongsByStatus('Suggested');
        $setListSongs       = $songsModel->getSongsByStatus('Set List');
        $reserveSongs       = $songsModel->getSongsByStatus('Reserved');
        $removedSongs       = $songsModel->getSongsByStatus('Removed');
        return [
            'addSongForm'       => $addSongForm,
            'suggestedSongs'    => $suggestedSongs,
            'setListSongs'      => $setListSongs,
            'reserveSongs'      => $reserveSongs,
            'removedSongs'      => $removedSongs,
        ];
    }
    
    /**
     * 
     */
    public function addSongAction()
    {
        $songsModel      = $this->songsModel;
        $addSongForm     = $songsModel->getAddSongForm();
        $request         = $this->getRequest();
        if($request->IsPost()) {
            $addSongForm->setData($request->getPost());
            $addSongForm->setInputFilter($addSongForm->getInputFilter());
            if($addSongForm->isValid()) {
                $songsModel->persistFlush();
                $suggestedSongs = $songsModel->getSongsByStatus('Suggested');
                $addSongForm    = $songsModel->getAddSongForm();
            } else {
                $this->getResponse()->setStatusCode(401);
                $suggestedSongs = $songsModel->getSongsByStatus('Suggested');
            }
        }
        $viewModel = new ViewModel();
        $viewModel->setVariables([
                'addSongForm'       => $addSongForm,
                'suggestedSongs'    => $suggestedSongs,
            ])
            ->setTemplate('application/index/partial/suggested-songs-table.phtml')
            ->setTerminal(true);
        return $viewModel;
    }
    
    /**
     * 
     */
    public function calendarAction()
    {
        $calendarModel   = $this->calendarModel;
        $addEventsForm   = $calendarModel->getAddEventsForm();
        $editEventsForm  = $calendarModel->getAddEventsForm();
        return [
            'addEventsForm'   => $addEventsForm,
            'editEventsForm'  => $editEventsForm,
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
        $addEventsForm   = $calendarModel->getAddEventsForm();
        $request         = $this->getRequest();
        if($request->IsPost()) {
            $addEventsForm->setData($request->getPost());
            $addEventsForm->setInputFilter($addEventsForm->getInputFilter());
            if($addEventsForm->isValid()) {
                $calendarModel->persistFlush();
            } else {
                $this->getResponse()->setStatusCode(401);
            }
        }
        $viewModel = new ViewModel();
        $viewModel->setVariables([
                'addEventsForm'   => $addEventsForm,
            ])
            ->setTemplate('application/index/partial/add-event-modal.phtml')
            ->setTerminal(true);
        return $viewModel;
    }
    
    /**
     * 
     */
    public function editEventAction()
    {
        $eventId = $this->params()->fromRoute('id', 0);
        if($eventId === 0) {
            return $this->redirect()->toRoute('unauthorised');
        }
        $calendarModel   = $this->calendarModel;
        $editEventsForm  = $calendarModel->getEditEventsForm($eventId);
        $request         = $this->getRequest();
        if($request->IsPost()) {
            $editEventsForm->setData($request->getPost());
            $editEventsForm->setInputFilter($editEventsForm->getInputFilter());
            if($editEventsForm->isValid()) {
                $calendarModel->flushEM();
            } else {
                $this->getResponse()->setStatusCode(401);
            }
        }
        $viewModel = new ViewModel();
        $viewModel->setVariables([
                'editEventsForm'   => $editEventsForm,
            ])
            ->setTemplate('application/index/partial/edit-event-modal.phtml')
            ->setTerminal(true);
        return $viewModel;
    }
    
    /**
     * 
     */
    public function removeEventAction()
    {
        $eventId = $this->params()->fromRoute('id', 0);
        if($eventId === 0) {
            return $this->redirect()->toRoute('unauthorised');
        }
        $request = $this->getRequest();
        if($request->IsPost()) {
            $calendarModel = $this->calendarModel;
            $calendarModel->removeEvent($eventId);
        }
        return new JsonModel([]);
    }
}
