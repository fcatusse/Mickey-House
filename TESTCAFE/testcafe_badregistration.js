import { Selector } from 'testcafe';
fixture `Getting Started`
  .page `http://localhost:8000/register`;

test('registration with a username already taken', async t => {
    await t
    .typeText('#username', 'Titi')
    .typeText('#firstname', 'John')
    .typeText('#lastname', 'Smith')
    .typeText('#email', 'truc@coding.com')
    .typeText('#address', '12 rue des Petits Champs')
    .typeText('#postal_code', '75002')
    .typeText('#city', 'Paris')
    .typeText('#password', 'john123')
    .typeText('#password-confirm', 'john123')
    .click('.btn-primary')
    .expect(Selector('.invalid-feedback').innerText).eql('The username has already been taken.');
});