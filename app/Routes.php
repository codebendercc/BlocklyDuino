<?php
// Routes.php

namespace app;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class Routes
{
    /**
     * Configures the routes for the application
     * @param Blocklyduino $app The current application
     */
    static function configure(Blocklyduino $app)
    {
        self::addRootRoute($app);
        self::addBlocklyRoute($app);
        self::addFrameRoute($app);
        self::addBuilderRoutes($app);
        self::addDownloadRoute($app);
        self::addExampleRoute($app);

        // Now let's define a handy asset path. Note that this has to come
        // after the other route definitions because we use the named URL
        // route.
        $app['asset_path'] = $app->path('home') . 'public/assets';
    }

    /**
     * Adds the paths necessary to punt requests off to CompilerFlasher.
     * @param Blocklyduino $app The current application
     */
    public static function addBuilderRoutes(Blocklyduino $app)
    {
        /* POST Requests */
        $app->post('/builder/compile', function (Request $request) use ($app) {
            // Break out what we got
            $requestContent = json_decode($request->getContent(), true);
            /*
             * Makes use of the latest codebender builder API, which
             * allows the service to handle both compilation and library-related
             * requests (code/example fetching, etc)
             */
            $builderRequestJSON = json_encode(array('type' => 'compiler', 'data' => $requestContent));

            // Guzzle it and return the results
            return $app['codebender.post']($app['codebender.builder'](), $builderRequestJSON);
        })->bind('compile');
    }

    public static function addRootRoute(Blocklyduino $app)
    {
        $app->get('/', function (Blocklyduino $app) {
            return $app['twig']->render('landing.html.twig');
        })->bind('home');
    }

    /**
     * Adds the CRUD methods for the / route of the application
     * @param Blocklyduino $app The current application
     */
    public static function addBlocklyRoute(Blocklyduino $app)
    {
        $app->get('/blockly_app', function (Blocklyduino $app) {
            $examples = self::getExamples();
            return $app['twig']->render('blockly.html.twig', [
                'examples' => $examples
            ]);
        })->bind('blockly_app');
    }

    /**
     * Adds the CRUD methods for the / route of the application
     * @param Blocklyduino $app The current application
     */
    public static function addFrameRoute(Blocklyduino $app)
    {
        $app->get('/blocklyframe', function (Blocklyduino $app) {
            return $app['twig']->render('frame.html.twig');
        })->bind('blocklyframe');
    }

    public static function addDownloadRoute(Blocklyduino $app)
    {
        $app->post('/download', function (Request $request) use ($app) {
            $downloadResponse = self::handleDownload($app, $request->request->all());
            return $downloadResponse;
        })->bind('download');
    }

    public static function addExampleRoute(Blocklyduino $app)
    {
        $app->post('/example', function (Request $request) use ($app) {
            $requestData = $request->request->all();
            if (!array_key_exists('example', $requestData)) {
                return new JsonResponse([
                    'success' => false,
                    'message' => 'Invalid request'
                ]);
            }

            $example = $requestData['example'];
            $example = self::getExample($example);

            $jsonResponse = [
                'success' => false,
                'message' => 'Example not found'
            ];

            if ($example['success']) {
                $jsonResponse = [
                    'success' => true,
                    'name' => $example['name'],
                    'code' => $example['code']
                ];
            }

            return new JsonResponse($jsonResponse);
        })->bind('example');
    }

    private function getExample($example)
    {
        $examplePath = implode('/', [getcwd(), 'examples', $example . '.xml']);

        if (!file_exists($examplePath)) {
            return [
                'success' => false
            ];
        }

        $contents = file_get_contents($examplePath);

        return [
            'success' => true,
            'name' => $example,
            'code' => $contents
        ];
    }

    private function getExamples()
    {
        $examplesPath = implode('/', [getcwd(), 'examples']);
        $examplesFiles = array_diff(scandir($examplesPath), array('..', '.'));
        $examples = [];
        foreach ($examplesFiles as $key => $value) {
            array_push($examples, preg_replace('/.[^.]*$/', '', $value));
        }

        return $examples;
    }

    private function handleDownload($app, $filelist)
    {
        $errorResponse = [
            'success' => false
        ];
        // No files inside the filelist
        if (count($filelist) == 0) {
            $errorResponse['message'] = 'Invalid filelist format.';
            return new JsonResponse($errorResponse);
        }
        $zipResponse = self::handleZipCreation($filelist);
        if ($zipResponse === false) {
            // @codeCoverageIgnoreStart
            $errorResponse['message'] = 'Error creating zip.';
            return new JsonResponse($errorResponse);
            // @codeCoverageIgnoreEnd
        }
        $headers = [
            'Content-Type' => 'text/html',
            'Content-Disposition' => 'attachment;filename="' . $zipResponse['zipName'] . '.zip"'
        ];
        return new Response($zipResponse['zipContents'], 200, $headers);
    }

    private function handleZipCreation($filelist)
    {
        $ZIP_TEMP_DIRECTORY = '/tmp';

        $tmpZipName = tempnam($ZIP_TEMP_DIRECTORY, 'proteus_');
        if ($tmpZipName === false) {
            // @codeCoverageIgnoreStart
            return false;
            // @codeCoverageIgnoreEnd
        }
        $zip = new \ZipArchive();
        // Try to open the new zip file
        if ($zip->open($tmpZipName, \ZipArchive::CREATE) !== true) {
            // @codeCoverageIgnoreStart
            return false;
            // @codeCoverageIgnoreEnd
        }
        // Get the first key of the filelist as the zip name
        reset($filelist);
        $zipName = key($filelist);
        $filenameRegExp = '/^(.*)\.([^.]*)$/';
        $zipName = preg_replace($filenameRegExp, '$1', $zipName);
        // Initialize the zip with an empty folder
        if ($zip->addEmptyDir($zipName) !== true) {
            // @codeCoverageIgnoreStart
            unlink($tmpZipName);
            return false;
            // @codeCoverageIgnoreEnd
        }
        $fileExtensionRegExp = '/^(_*)\_([^_]*)$/';
        foreach ($filelist as $filename => $contents) {
            $filename = preg_replace($fileExtensionRegExp, '$1.$2', $filename);
            $filename = preg_replace('/^(.+)_(.+)$/', '$1.$2', $filename);
            $zip->addFromString($zipName . '/' . $filename, $contents);
        }
        $zip->close();
        $zipContents = file_get_contents($tmpZipName);
        unlink($tmpZipName);
        return [
            'zipName' => $zipName,
            'zipContents' => $zipContents
        ];
    }
}
