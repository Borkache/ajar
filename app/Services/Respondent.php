<?php

namespace App\Services;

use League\Fractal\Manager as FractalManager;
use Illuminate\Http\JsonResponse;
use App\Services\Fractal\JsonApiSerializer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Item as FractalItem;
use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\TransformerAbstract;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Collection as EloquentCollection;
use Illuminate\Http\Request;
use App\Exceptions\Api\InputFieldsValidationException;

class Respondent
{

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var FractalManager
     */
    protected $fractalManager;


    /**
     * Respondent constructor.
     * @param Request $request
     * @param FractalManager $fractalManager
     * @param ResponseLogger $logger
     */
    public function __construct
    (
        Request $request,
        FractalManager $fractalManager,
        ResponseLogger $logger
    )
    {
        $fractalManager->setSerializer(new JsonApiSerializer);
        $this->request = $request;
        $this->fractalManager = $fractalManager;
        $this->logger = $logger;
    }


    /**
     * @param AbstractPaginator $paginator
     * @param TransformerAbstract $transformer
     * @return JsonResponse
     */
    public function respondWithPagination(AbstractPaginator $paginator, TransformerAbstract $transformer)
    {
        $resource = new FractalCollection($paginator->getCollection(), $transformer);
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return $this->respondJson( $this->fractalManager->createData($resource)->toArray());

    }

    /**
     * @param EloquentModel $item
     * @param TransformerAbstract $transformer
     * @param int $code
     * @return JsonResponse
     */
    public function respondItem(EloquentModel $item, TransformerAbstract $transformer, $code = 200)
    {
        $resource = new FractalItem($item, $transformer);
        return $this->respondJson(
            $this->fractalManager->createData($resource)->toArray(),
            $code
        );
    }

    /**
     * @param EloquentCollection $collection
     * @param TransformerAbstract $transformer
     * @param null $paginationData
     * @return JsonResponse
     */
    public function respondCollection(
        EloquentCollection $collection,
        TransformerAbstract $transformer,
        $paginationData = null
    )
    {
        $resource = new FractalCollection($collection, $transformer);
        $responseData = $this->fractalManager->createData($resource)->toArray();
        if(is_array($paginationData)){
            $responseData['pagination'] = $paginationData;
        }

        return $this->respondJson($responseData);

    }

    /**
     * @param $collection
     * @param TransformerAbstract $transformer
     * @param null $paginationData
     * @param int $code
     * @return JsonResponse
     */
    public function respondArray($collection, TransformerAbstract $transformer, $paginationData = null, $code = 200)
    {
        $resource = new FractalCollection($collection, $transformer);
        $return = $this->fractalManager->createData($resource)->toArray();
        // filter 'null' items that could be appeared in the Transformer (in filtering process)
        $return['data'] = collect($return['data'])->reject(function ($item) { return empty($item); })->all();
        if(is_array($paginationData)){
            $return['pagination'] = $paginationData;
        }
        return $this->respondJson($return, $code);

    }

    /**
     * @param array $responseData
     * @param int $code
     * @return JsonResponse
     */
    public function respondJson(array $responseData = ["data"=>[]], $code = 200 )
    {
        $responseData['code'] = $this->getResponseHashCode();
        $response =  new JsonResponse( $responseData, $code, $this->headers);
        $this->storeResponse($response);
        return $response;
    }

    /**
     * @param Request $request
     * @param array $responseData
     * @param int $code
     * @param \Exception $exception
     * @return JsonResponse
     */
    public function respondErrorJson(
        Request $request,
        \Exception $exception,
        array $responseData = [],
        $code = 400
    )
    {
        $responseData['code'] = $this->getResponseHashCode($request);
        $response =  new JsonResponse($responseData, $code, $this->headers);
        try{
            $this->storeErrorResponse($request, $response, $exception);
        } catch (\Exception $e){}
        return $response;
    }

    /**
     * @param Request $request
     * @param InputFieldsValidationException $exception
     * @param array $responseData
     * @param array $errors
     * @param int $code
     * @return JsonResponse
     */
    public function respondValidationErrorJson(
        Request $request,
        InputFieldsValidationException $exception,
        array $responseData = [],
        array $errors = [],
        $code = 400
    )
    {
        $responseData['code'] = $this->getResponseHashCode($request);
        $fieldName = $exception->getFieldName();
        if(!empty($errors)){
            foreach ($errors as $field => $fieldErrors){
                if(is_array($fieldErrors)){
                    foreach ($fieldErrors as $currentError){
                        $responseData['errors'][] = [
                            $fieldName => $field,
                            'message' => $currentError
                        ];
                    }
                } else {
                    $responseData['errors'][] = [
                        'message' => stripcslashes($fieldErrors)
                    ];
                }

            }
        }
        $response =  new JsonResponse( $responseData, $code);
        $this->storeErrorResponse($request, $response, $exception);
        return $response;
    }



}
