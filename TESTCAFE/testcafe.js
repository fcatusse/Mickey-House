import { Selector } from 'testcafe';
fixture `Getting Started`
  .page `http://localhost:8000/register`;

test('Registration', async t => {
	await t
    .typeText('#username', 'Titi')
    .typeText('#firstname', 'Guislaine')
    .typeText('#lastname', 'Arabian')
    .typeText('#email', 'guislaine@coding.com')
    .typeText('#address', '10 rue des Petits Champs')
    .typeText('#postal_code', '75002')
    .typeText('#city', 'Paris')
    .typeText('#password', 'guislaine')
    .typeText('#password-confirm', 'guislaine')
    .click('.btn-primary')
    .expect(Selector('.alert-succcess').innerText).eql('Welcome!');
});



