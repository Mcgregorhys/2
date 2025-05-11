<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
//dodaję
use App\Entity\Product;
use App\Form\ProductTypeForm;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class ProductController extends AbstractController
{
    #[Route('/product/new', name: 'product_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        //tworzę zminną produkt jako nowy obiekt klasy produkt
        $product = new Product();
        //tworzę zmienną form i przypisuję ją do metody createform i przekazuję jako argumenty klasę ProductType oraz product
        $form = $this->createForm(ProductTypeForm::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //Wyliczenie ceny brutto
            $cenaNetto = $product ->getCenaNetto();
            $vat = $product -> getVat();
            $product->setCenaBrutto($cenaNetto +($cenaNetto * $vat/ 100));
            $amount = $product->getAmount();
            $product->setAmount( $amount);
            $product->setValue($cenaNetto * $amount);

            //zapis do bazy danych (jeśli używane jest Doctrine)
            $entityManager->persist($product);
            $entityManager->flush();

            //przekiewowanie po zapisaniu
            return $this->redirectToRoute('product_list');

        }

        return $this->render('product/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/', name: 'product_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        //pobranie wszystkich produktów z bazy danych
        $products = $entityManager->getRepository(Product::class)->findAll();
        //Renderowanie widoku i przekazanie produktów
        return $this ->render('product/list.html.twig', [
            'products'=> $products,
        ]);
    }
    
    #[Route('/product/delete-selected', name: 'product_delete_selected', methods: ['POST'])]
    public function deleteSelected(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Pobierz identyfikatory zaznaczonych produktów
        $selectedProducts = $request->request->all('selected_products');
    
        if (!empty($selectedProducts)) {
            // Pobierz produkty z bazy danych
            $products = $entityManager->getRepository(Product::class)->findBy(['id' => $selectedProducts]);
    
            // Usuń produkty
            foreach ($products as $product) {
                $entityManager->remove($product);
            }
    
            $entityManager->flush();
    
            $this->addFlash('success', 'Zaznaczone produkty zostały usunięte.');
        } else {
            $this->addFlash('warning', 'Nie wybrano żadnych produktów do usunięcia.');
        }
    
        return $this->redirectToRoute('product_list');
    }
    

#[Route('/product/update/{id}', name: 'product_update', methods: ['POST'])]
public function update(int $id, Request $request, EntityManagerInterface $entityManager): Response
{
    // $product = $entityManager->getRepository(Product::class)->find($id);
    // $product = $product->getNazwaProduktu();
    // $product = $product->getAmount();
    // $product = $product->getCenaNetto();
    // $product = $product->getVat();
    // $product = $product->getCenaBrutto();
    // $product = $product->getValue();


    if (!$product) {
        $this->addFlash('warning', 'Produkt nie został znaleziony.');
        return $this->redirectToRoute('product_list');
    }

    // Pobranie danych z formularza
    $nazwaProduktu = $request->request->get('nazwaProduktu');
    $amount = $request->request->get('amount');// Upewnij się, że 'amount' jest aktualizowane
    $cenaNetto = $request->request->get('cenaNetto');
    $vat = $request->request->get('vat');
    $cenaBrutto = $request->request->get('cenaBrutto');
    $value = $request->request->get('value');

    // Aktualizacja produktu
    $product->setNazwaProduktu($nazwaProduktu);
    $product->setAmount((int)$request->request->get('amount')); // Upewnij się, że ilość jest aktualizowana
    $product->setCenaNetto((float)$cenaNetto);
    $product->setVat((int)$vat);
    $product->setCenaBrutto($product->getCenaNetto() + ($product->getCenaNetto() * $product->getVat() / 100));
    $product->setValue($product->getCenaBrutto() * $product->getAmount());

    $entityManager->flush();

    $this->addFlash('success', 'Produkt został zaktualizowany.');
    return $this->redirectToRoute('product_list');
}
#[Route('/product/edit-or-delete', name: 'product_edit_or_delete', methods: ['POST'])]
public function editOrDelete(Request $request, EntityManagerInterface $entityManager): Response
{
    // Pobierz akcję (update/delete)
    $action = $request->request->get('action'); // Wartość scalarna (string)
    
    // Pobierz dane produktów jako tablica
    $productsData = $request->request->all('products'); // Zamiast `get`, użyj `all` dla tablicy

    // Pobierz identyfikatory do usunięcia
    $toDelete = $request->request->all('to_delete', []); // Może pozostać `get`, ponieważ `to_delete[]` jest tablicą

    if ($action === 'update') {
        // AKTUALIZACJA PRODUKTÓW
        foreach ($productsData as $id => $data) {
            $product = $entityManager->getRepository(Product::class)->find($id);

            if ($product) {
                $product->setNazwaProduktu($data['nazwaProduktu']);
                $product->setAmount((int)$data['amount']);
                $product->setCenaNetto((float)$data['cenaNetto']);
                $product->setVat((int)$data['vat']);
                $product->setCenaBrutto($product->getCenaNetto() + ($product->getCenaNetto() * $product->getVat() / 100));
                $product->setValue($product->getCenaNetto() * $product->getAmount());
            }
        }
        $entityManager->flush();
        $this->addFlash('success', 'Produkty zostały zaktualizowane.');
    } elseif ($action === 'delete') {
        // USUWANIE PRODUKTÓW
        if (!empty($toDelete)) {
            $productsToDelete = $entityManager->getRepository(Product::class)->findBy(['id' => $toDelete]);

            foreach ($productsToDelete as $product) {
                $entityManager->remove($product);
            }
            $entityManager->flush();
            $this->addFlash('success', 'Wybrane produkty zostały usunięte.');
        } else {
            $this->addFlash('warning', 'Nie zaznaczono żadnych produktów do usunięcia.');
        }
    } else {
        $this->addFlash('danger', 'Nieznana akcja.');
    }

    return $this->redirectToRoute('product_list');
}

}
