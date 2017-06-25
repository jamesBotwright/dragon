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
        return new ViewModel();
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
