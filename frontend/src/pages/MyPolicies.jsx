import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

function MyPolicies() {
  return (
    <div className="mx-auto max-w-3xl p-6">
      <Card>
        <CardHeader>
          <CardTitle>Мои полисы</CardTitle>
        </CardHeader>
        <CardContent>
          <p className="text-muted-foreground">Полисы появятся здесь в будущем.</p>
        </CardContent>
      </Card>
    </div>
  );
}

export default MyPolicies;