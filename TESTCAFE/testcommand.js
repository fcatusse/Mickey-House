import { Selector } from 'testcafe';
import { Role } from 'testcafe';

fixture `Orders`
  .page `http://localhost:8000/home`;

const userLogged = Role('http://localhost:8000/login', async t => {
await t
    .typeText('#email', 'user@user.com')
    .typeText('#password', 'user')
    .click('.btn-primary');
});

test('orders', async t => {
    await t
        .useRole(userLogged)
        .wait(2000)
        .typeText('#searchform', 'gateau')
   		.click('.btn-secondary')
        .expect(Selector('.alert-primary').innerText).eql('1 résultats pour le mot clé "gateau"')
        .wait(1000)
        .click('.btn-primary')
         .wait(1000)
         .click(Selector('#nb_servings'))
		.click(Selector('#nb_servings').find('option').withText('1 - 3€'))
        .click('#purchaseButton')
         .expect(Selector('.alert-success').innerText).eql('Votre commande a été passée')
         .click('#navbarDropdown')
        .wait(1000)
		.click('#my-orders')
		.wait(2000);

});