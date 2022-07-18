<?php

namespace App\Controller;

use App\Form\ImportType;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class FooController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function __invoke(Request $request, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ImportType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $form->get('file')->getData();

            if (is_null($file)) {
                throw new \Exception('Invalid file');
            }

            $extension = $file->guessExtension();

            $reader = match ($extension) {
                'csv' => new Csv(),
                'xls' => new Xls(),
                'xlsx' => new Xlsx(),
                default => null,
            };

            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            $safeFilename = $slugger->slug(strtolower($originalFilename));
            $newFilename = $safeFilename . '-' . uniqid() . '-' . (new \DateTime())->getTimestamp() . '.' . $extension;

            $uploadsDir = $this->getParameter('uploadsDir');

            if (!is_dir($uploadsDir)) {
                mkdir($uploadsDir);
            }

            $file->move(
                $uploadsDir,
                $newFilename
            );

            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($uploadsDir . '/' . $newFilename);
        }

        return $this->render('index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
